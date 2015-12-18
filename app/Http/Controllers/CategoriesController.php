<?php

namespace App\Http\Controllers;

use App\Category;
use App\PostStatus;
use App\Http\Composers\NavigationBuilder\Navigator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;
use KouTsuneka\FlashMessage\Flash;
use Illuminate\Database\QueryException;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('postsCount')->orderBy('id','desc')->get();
        return view('admin.category_index', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            'slug' => 'required|min:4|unique:category,slug',
            'description' => 'min:6|max:1000',
            'parent_id' => 'exists:category,id'
        ]);

        $input = $request->all();

        $cat = new Category($input);

        if(isset($input['parent_id']) && !empty($input['parent_id']))
            $cat->parent_id = $input['parent_id'];

        if($cat->save())
            Flash::push("Thêm chuyên mục \\\"$cat->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Thêm chuyên mục thất bại", 'Hệ thống', "error");

        return redirect()->action('CategoriesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Category::findOrFail($id);
        $categories = Category::where('id', '<>', $id)->get();
        return view('admin.category_edit', ['category' => $cat, 'categories' => $categories]);
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

        $cat = Category::findOrFail($id);

        $input = $request->all();

        $cat->parent_id = empty($input['parent_id']) || $input['parent_id'] == $id ? null : $input['parent_id'];
        if($cat->update($input))
            Flash::push("Sửa chuyên mục \\\"$cat->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Sửa chuyên mục thất bại", 'Hệ thống', "error");
        return redirect(action('CategoriesController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            if(Category::destroy($id))
                Flash::push("Xóa chuyên mục thành công", 'Hệ thống');
            else
                Flash::push("Xóa chuyên mục thất bại", 'Hệ thống', 'error');
        }
        catch(QueryException $ex)
        {
            Flash::push("Xóa chuyên mục thất bại", 'Hệ thống', 'error');
        }
        return redirect(action('CategoriesController@index'));
    }
}
