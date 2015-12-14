<?php

namespace App\Http\Controllers;

use App\Category;
use App\PostStatus;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('postsCount')->get();
        return view('admin.category_create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'slug' => 'unique:category,slug',
            'description' => 'min:6|max:1000',
            'parent_id' => 'exists:category,id'
        ]);

        $input = $request->all();

        $cat = new Category($input);

        if(isset($input['parent_id']) && !empty($input['parent_id']))
            $cat->parent_id = $input['parent_id'];

        if($cat->save())
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
        $categories = Category::all();
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
        $this->validate($request, [
            'name' => 'required|min:4',
            'slug' => "unique:category,slug," . $id,
            'description' => 'min:6|max:1000',
            'parent_id' => 'exists:category,id'
        ]);

        $cat = Category::findOrFail($id);

        $input = $request->all();
        $cat->update($input);
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
        if(Category::destroy($id))
            return redirect(action('CategoriesController@index'));
        return redirect(action('CategoriesController@index'));
    }
}
