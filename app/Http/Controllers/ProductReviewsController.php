<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductReview;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use KouTsuneka\FlashMessage\Flash;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class ProductReviewsController extends Controller
{
    /**
     * @var string
     */
    protected $config_key = '_review';

    /**
     * @var array
     */
    protected $configs = [
        'filter' => [
            'status_type' => 'notchecked',
            'product' => null,
            'search_term' => null
        ]
    ];
    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.show_checked' => 'boolean',
        'filter.search_term' => 'min:4,max:255',
        'filter.status_type' => 'in:all,notchecked,checked',
        'filter.product' => 'exists:product,id'
    ];

    public function __construct()
    {
        $this->load_config('filter');
    }


    public function index()
    {
        $this->authorize('indexProductReview');

        $configs = $this->read_configs(['filter.status_type', 'filter.search_term', 'filter.product']);

        $product_id = $configs['filter_product'];

        $configs['filter_product'] = Product::find($configs['filter_product']) ?: null;



        $reviews = ProductReview::with([
            'user' => function($query) {
                $query->addSelect(['id', 'name']);
            },
            'product' => function($query) use($product_id)
            {
                $query->addSelect(['id', 'name', 'slug']);
                if($product_id)
                    $query->where('id', '=', $product_id);
            }]);

        if($product_id)
            $reviews->whereHas('product', function($query) use($product_id) {
                $query->where('id', '=', $product_id);
            });

        if($configs['filter_status_type'] == 'checked')
            $reviews->hasChecked();
        else if($configs['filter_status_type'] == 'notchecked')
            $reviews->hasNotChecked();



        if($configs['filter_search_term'])
            $reviews->searchByTerm($configs['filter_search_term']);

        $reviews = $reviews->latest()->paginate(20);

        return view('admin.shop.product_review_index', array_merge(compact(['reviews']), $configs));
    }

    public function check(ProductReview $product_review_id)
    {
        $this->authorize('checkProductReview');

        if($product_review_id->check())
            Flash::push("Duyệt đánh giá sản phẩm #\\\"$product_review_id->id\\\" thành công", 'Hệ thống');
        else
            Flash::push("Duyệt đánh giá sản phẩm #\\\"$product_review_id->id\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $this->authorize('destroyProductReview');

        $id = $request->request->get('review_id');

        if(empty($id))
            throw new BadRequestHttpException();

        try
        {
            if(ProductReview::destroy($id))
                Flash::push("Xóa đánh giá sản phẩm  thành công", 'Hệ thống');
            else
                Flash::push("Xóa đánh giá sản phẩm thất bại", 'Hệ thống', 'error');
        }
        catch(QueryException $ex)
        {
            Flash::push("Xóa đánh giá sản phẩm thất bại", 'Hệ thống', 'error');
        }
        return redirect(action('ProductReviewsController@index'));
    }

    public function edit($id)
    {
        $this->authorize('updateProductReview');

        $review = ProductReview::with([
            'product' => function($query){
                $query->addSelect(['id', 'name', 'slug']);
            },
            'user'
        ])->findOrFail($id);

        return view('admin.shop.product_review_edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('updateProductReview');

        $review = ProductReview::findOrFail($id);

        $this->validate($request, [
            'user_id' => 'required_without:name,email|exists:user,id',
            'name' => 'required_without:user_id|min:4|max:20',
            'email' => 'required_without:user_id|email',
            'product_id' => 'required|exists:post,id',
            'content' => 'required|min:4|max:1000',
            'created_at' => 'date_format:Y-m-d H:i:s'
        ]);

        $input = $request->input();
        $review->created_at = $input['created_at'];
        $review->product_id = $input['product_id'];
        $review->user_id = isset($input['user_id']) ? $input['user_id'] : null;
        $review->fill($input);

        if($review->save())
            Flash::push("Sửa bình luận #$review->id thành công", 'Hệ thống');
        else
            Flash::push("Sửa bình luận #$review->id thất bại", 'Hệ thống');

        return redirect(action('ProductReviewsController@edit', ['id' => $id]));
    }
}
