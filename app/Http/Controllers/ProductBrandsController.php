<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductBrand;
use KouTsuneka\FlashMessage\Flash;

class ProductBrandsController extends Controller
{
    public function index()
    {

        $brands = ProductBrand::with('productsCount')->orderBy('id','desc')->get();

        return view('admin.shop.product_brand_index', compact('brands'));
    }

    public function store(Request $request)
    {
        $this->authorize('storeProductBrand');
        $slug = $request->request->get('slug');
        $label = $request->request->get('label');

        if(empty($slug) && !empty($label))
        {
            $slug = str_slug($request->request->get('label'));
            if(strlen($slug) >= 4)
                $request->request->set('slug', $slug);
        }

        $this->validate($request, [
            'name' => 'required|min:4|max:50',
            'label' => 'required|min:4|max:255',
            'slug' => 'required|min:4|max:255|unique:product_brand,slug',
            'description' => 'min:6|max:1000'
        ]);

        $input = $request->all();

        $brand = new ProductBrand($input);

        if($brand->save())
            Flash::push("Thêm danh mục sản phẩm \\\"$brand->label\\\" thành công", 'Hệ thống');
        else
            Flash::push("Thêm danh mục sản phẩm \\\"$brand->label\\\" thất bại", 'Hệ thống', "error");

        return redirect()->action('ProductCategoriesController@index');
    }

    public function edit($id)
    {
        $this->authorize('updateProductBrand');

        $brand = ProductBrand::findOrFail($id);

        return view('admin.shop.product_brand_edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('updateProductBrand');

        $slug = $request->request->get('slug');
        $label = $request->request->get('label');
        if(empty($slug) && !empty($label))
        {
            $slug = str_slug($request->request->get('label'));
            if(strlen($slug) >= 4)
                $request->request->set('slug', $slug);
        }

        $this->validate($request, [
            'name' => 'required|min:4|max:50',
            'label' => 'required|min:4|max:255',
            'slug' => 'required|min:4|max:255|unique:product_brand,slug,' . $id,
            'description' => 'min:6|max:1000'
        ]);

        $brand = ProductBrand::findOrFail($id);

        $input = $request->all();

        if($brand->update($input))
            Flash::push("Sửa nhãn hiệu sản phẩm \\\"$brand->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Sửa nhãn hiệu sản phẩm thất bại", 'Hệ thống', "error");

        return redirect(action('ProductBrandsController@index'));
    }

    public function destroy(Request $request)
    {
        $this->authorize('destroyProductBrand');

        $brand = ProductBrand::findOrFail($request->request->get('brand_id'));

        try
        {
            if(ProductBrand::destroy($brand->id))
                Flash::push("Xóa danh mục sản phẩm \\\"$brand->label\\\"thành công", 'Hệ thống');
            else
                Flash::push("Xóa danh mục sản phẩm \\\"$brand->label\\\" thất bại", 'Hệ thống', 'error');
        }
        catch(QueryException $ex)
        {
            Flash::push("Xóa danh mục sản phẩm thất bại", 'Hệ thống', 'error');
        }

        return redirect(action('ProductBrandsController@index'));
    }
}
