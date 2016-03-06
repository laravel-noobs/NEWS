<?php

namespace App\Http\Controllers;

use App\ProductStatus;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\URL;
use App\ProductCategory;
use KouTsuneka\FlashMessage\Flash;

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

        $products  = Product::with(['category', 'status', 'feedbacksCount', 'commentsCount', 'reviewsCount'])
            ->hasStatus($configs['filter_status_type']);

        $categories = ProductCategory::all(['id', 'name']);

        if($configs['filter_category'])
            $products->hasCategory($configs['filter_category']);

        if(!empty(trim($configs['filter_search_term'])))
            $products->searchInName(trim($configs['filter_search_term']));

        $products = $products->latest()->paginate(20);

        return view('admin.shop.product_index', array_merge(compact('products', 'categories'), $configs));
    }

    /**
     * @param $slug
     */
    public function show($slug)
    {
        dd($slug);
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

        $products = Product::searchInName($term)->get(['id', 'name', 'slug']);

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
