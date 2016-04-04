<?php

namespace App\Http\Controllers;

use App\ProductBrand;
use App\ProductStatus;
use App\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\URL;
use App\ProductCategory;
use Illuminate\Support\Facades\Validator;
use KouTsuneka\FlashMessage\Flash;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * @var string
     */
    protected $config_key = '_post';

    /**
     * @var array
     */
    protected $configs = [
        'filter' => [
            'status_type' => 'all',
            'category' => null,
            'search_term' => null
        ]
    ];

    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.search_term' => 'min:4,max:255',
        'filter.category' => 'exists:category,id',
        'filter.status_type' => 'in:all,outofstock,available,disabled'
    ];

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $configs = $this->read_configs(['filter.status_type', 'filter.category', 'filter.search_term']);

        $products  = Product::with([
            'category',
            'status',
            'feedbacksCount',
            'commentsCount',
            'reviewsCount',
            'tags' => function($query) {
                $query->addSelect(['id', 'name']);
            }
        ])
            ->hasStatus($configs['filter_status_type']);

        $categories = ProductCategory::all(['id', 'name']);

        if($configs['filter_category'])
            $products->hasCategory($configs['filter_category']);

        if(!empty(trim($configs['filter_search_term'])))
            $products->searchInName(trim($configs['filter_search_term']));

        $products = $products->latest()->paginate(20);

        return view('admin.shop.product_index', array_merge(compact('products', 'categories'), $configs));
    }

    public function create()
    {
        $this->authorize('storeProduct');

        $product_status = ProductStatus::all();
        $categories = ProductCategory::all();
        $brands = ProductBrand::all();

        $post_status_default_id = 2;

        return view('admin.shop.product_create', compact('product_status', 'post_status_default_id', 'categories', 'brands'));
    }

    public function store(Request $request)
    {
        $this->authorize('storeProduct');

        $slug = $request->request->get('slug');
        $name = $request->request->get('name');
        if(empty($slug) && !empty($name))
        {
            $slug = str_slug($request->request->get('name'));
            if(strlen($slug) >= 4)
                $request->request->set('slug', $slug);
        }

        $this->validate($request, [
            'name' => 'required|min:4|max:255',
            'slug' => 'required|min:4|max:255|unique:product,slug',
            'description' => 'min:6|max:1000',
            'image' => 'url',
            'featured_image' => 'url',
            'package' => 'max:255',
            'price' => 'required|min:0|max:99999999',
            'brand_id' => 'required|exists:product_brand,id',
            'status_id' => 'required|exists:product_status,id',
            'category_id' => 'required|exists:product_category,id'
        ]);

        $input = $request->input();
        $product = new Product($input);
        $product->status_id = $input['status_id'];

        if($product->save())
            Flash::push("Thêm sản phẩm \\\"$product->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Thêm sản phẩm thất bại", 'Hệ thống', "error");

        return redirect()->action('ProductsController@index');
    }
    /**
     * @param $slug
     */
    public function show($slug)
    {
        dd($slug);
    }

    public function edit($id)
    {
        $product = Product::with([
            'status',
            'brand',
            'category',
            'tags' => function($query) {
                $query->addSelect(['id', 'name']);
            }
        ])->findOrFail($id);

        $categories = ProductCategory::all(['id', 'name']);

        $product_status = ProductStatus::all(['id', 'label']);

        $brands = ProductBrand::all(['id', 'name']);

        return view('admin.shop.product_edit', compact('product', 'categories', 'brands', 'product_status'));
    }

    public function update($id, Request $request)
    {
        $this->authorize('updateProduct');

        $product = Product::findOrFail($id);

        $slug = $request->request->get('slug');
        $name = $request->request->get('name');
        if(empty($slug) && !empty($name))
        {
            $slug = str_slug($request->request->get('name'));
            if(strlen($slug) >= 4)
                $request->request->set('slug', $slug);
        }

        $input = $request->all();

        list($input, $tags, $new_tags) = $this->prepareInput($input);

        $validator = Validator::make($input, [
            'name' => 'required|min:4|max:255',
            'slug' => 'required|min:4|max:255|unique:product,slug,' . $product->id,
            'description' => 'min:6|max:1000',
            'image' => 'url',
            'featured_image' => 'url',
            'package' => 'max:255',
            'price' => 'required|min:0|max:99999999',
            'brand_id' => 'required|exists:product_brand,id',
            'status_id' => 'required|exists:product_status,id',
            'category_id' => 'required|exists:product_category,id',
            'new_tags.*.name' => 'required|min:4',
            'new_tags.*.slug'=> 'required|min:4|unique:tag,slug'
        ]);

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($input);
        }

        list($result, $product) = $this->updateTransaction($product, $input, $new_tags, $tags);

        if($result)
            Flash::push("Sửa chuyên mục \\\"$product->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Sửa chuyên mục thất bại", 'Hệ thống', "error");

        return redirect(action('ProductsController@index'));
    }

    /**
     * @param $new_tags
     * @return array
     */
    protected function createNewTags($new_tags, &$tags)
    {
        foreach ($new_tags as $tag) {
            array_push($tags, Tag::create($tag));
        }
    }
    /**
     * @param $input
     * @return array
     */
    protected function prepareInput($input)
    {
        list($tags, $new_tags, $input) = $this->determineTags($input);

        $input = array_merge($input, ['new_tags' => $new_tags], ['existed_tags' => $tags]);

        return array($input, $tags, $new_tags);
    }

    /**
     * @param $input
     * @return array
     */
    protected function determineTags($input)
    {
        $tags = [];
        $new_tags = [];
        if (isset($input['tags'])) {
            foreach ($input['tags'] as $tag_id) {
                if (strrpos($tag_id, '*-', -strlen($tag_id)) !== FALSE) {
                    $tag_id = substr($tag_id, 2);
                    $tag_slug = str_slug($tag_id);
                    array_push($new_tags, ['name' => $tag_id, 'slug' => $tag_slug]);
                } else {
                    $tag = Tag::find($tag_id, ['id', 'name']);
                    if ($tag != null)
                        array_push($tags, $tag);
                }
            }
        }
        return array($tags, $new_tags, $input);
    }

    protected function updateTransaction($product, $input, $new_tags, $tags)
    {
        DB::beginTransaction();
        try {
            if ($input['category_id'] == null)
                $input['category_id'] = Category::create(['name' => $input['category_name'], 'slug' => $input['category_slug']])->id;

            $this->createNewTags($new_tags, $tags);

            if(array_has($input,'status_id'))
                $product->status_id = $input['status_id'];
            $product->category_id =  $input['category_id'];
            $product->fill($input);

            if ($product->save()) {
                $product->tags()->sync(collect($tags)->pluck('id')->all());

                DB::commit();
                return array(true, $product);
            }
            else
            {
                DB::rollBack();
                return array(false, $product);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return array(false, null);
        }
        return array(false, null);
    }
    /**
     * @param Request $request
     * @return null
     */
    public function queryProducts(Request $request)
    {
        // @TODO

        $term = $request->request->get('query');

        if(strlen($term) < 3)
            return null;

        $products = Product::searchInName($term)->get(['id', 'name', 'slug', 'image']);

        foreach($products as $product)
            $product->url = URL::action('ProductsController@show', ['slug' => $product->slug]);

        return $products;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Request $request)
    {
        $this->authorize('disableProduct');

        $product = Product::findOrFail($request->request->get('product_id'));

        if($product->disable())
            Flash::push("Vô hiệu sản phẩm \\\"$product->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Vô hiệu sản phẩm \\\"$product->name\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Request $request)
    {
        $this->authorize('enableProduct');

        $product = Product::findOrFail($request->request->get('product_id'));

        if($product->enable())
            Flash::push("Sản phẩm \\\"$product->name\\\" đã được chuyển sang trạng thái hết hàng", 'Hệ thống');
        else
            Flash::push("Cho phép sản phẩm \\\"$product->name\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws BadRequestHttpException
     */
    public function destroy(Request $request)
    {
        $this->authorize('destroyProduct');

        $id = $request->request->get('product_id');
        if(empty($id))
            throw new BadRequestHttpException();

        try
        {
            if(Product::destroy($id))
                Flash::push("Xóa sản phẩm thành công", 'Hệ thống');
            else
                Flash::push("Xóa sản phẩm thất bại", 'Hệ thống', 'error');
        }
        catch(QueryException $ex)
        {
            Flash::push("Xóa sản phẩm thất bại", 'Hệ thống', 'error');
        }
        return redirect(action('ProductsController@index'));
    }
}
