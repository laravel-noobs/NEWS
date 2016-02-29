<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use KouTsuneka\FlashMessage\Flash;

class ProductCategoriesController extends Controller
{
    public function index()
    {
        $this->authorize('indexProductCategory');

        $categories = ProductCategory::with('productsCount')->orderBy('id','desc')->get();

        return view('admin.shop.product_category_index', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('storeProductCategory');

        $slug = $request->request->get('slug');
        $name = $request->request->get('name');
        if(empty($slug) && !empty($name))
        {
            $slug = str_slug($request->request->get('name'));
            if(strlen($slug) >= 4)
                $request->request->set('slug', $slug);
        }

        $this->validate($request, [
            'name' => 'required|min:4',
            'slug' => 'required|min:4|unique:product_category,slug',
            'description' => 'min:6|max:1000',
            'parent_id' => 'exists:product_category,id'
        ]);

        $input = $request->all();

        $cat = new ProductCategory($input);

        if(isset($input['parent_id']) && !empty($input['parent_id']))
            $cat->parent_id = $input['parent_id'];

        if($cat->save())
            Flash::push("Thêm danh mục sản phẩm \\\"$cat->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Thêm danh mục sản phẩm thất bại", 'Hệ thống', "error");

        return redirect()->action('ProductCategoriesController@index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('updateProductCategory');

        $cat = ProductCategory::findOrFail($id);

        $categories = ProductCategory::where('id', '<>', $id)->get();

        return view('admin.shop.product_category_edit', ['category' => $cat, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('updateProductCategory');

        $slug = $request->request->get('slug');
        $name = $request->request->get('name');
        if(empty($slug) && !empty($name))
        {
            $slug = str_slug($request->request->get('name'));
            if(strlen($slug) >= 4)
                $request->request->set('slug', $slug);
        }

        $this->validate($request, [
            'name' => 'required|min:4',
            'slug' => 'required|min:4|unique:category,slug,' . $id,
            'description' => 'min:6|max:1000',
            'parent_id' => 'exists:category,id'
        ]);

        $cat = ProductCategory::findOrFail($id);

        $input = $request->all();

        $cat->parent_id = empty($input['parent_id']) || $input['parent_id'] == $id ? null : $input['parent_id'];
        if($cat->update($input))
            Flash::push("Sửa chuyên mục \\\"$cat->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Sửa chuyên mục thất bại", 'Hệ thống', "error");
        return redirect(action('ProductCategoriesController@index'));
    }


    public function destroy(Request $request)
    {
        $this->authorize('destroyProductCategory');

        $cat = ProductCategory::findOrFail($request->request->get('cat_id'));

        try
        {
            if(ProductCategory::destroy($cat->id))
                Flash::push("Xóa danh mục sản phẩm \\\"$cat->name\\\"thành công", 'Hệ thống');
            else
                Flash::push("Xóa danh mục sản phẩm \\\"$cat->name\\\" thất bại", 'Hệ thống', 'error');
        }
        catch(QueryException $ex)
        {
            Flash::push("Xóa danh mục sản phẩm thất bại", 'Hệ thống', 'error');
        }

        return redirect(action('ProductCategoriesController@index'));
    }
}
