<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Support\Facades\Redirect;
use KouTsuneka\FlashMessage\Flash;

class TagsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tags = Tag::with(['postsCount'])->orderBy('id', 'desc')->paginate(20);
        return view('admin.tag_index', compact('tags'));
    }

    /**
     * @param Request $request
     * @return null
     */
    public function queryTags(Request $request)
    {
        $term = $request->request->get('query');
        if(strlen($term) < 3)
            return null;
        $tag = Tag::where('name', 'LIKE', '%' . $term . '%')->get(['id', 'name']);
        return $tag;
    }

    /**
     * @param Request $request
     * @return Redirect
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

        $this->validate($request,[
            'name' => 'required|min:4',
            'slug'=> 'required|min:4|unique:tag,slug',
        ]);

        $input = $request->input();

        if($tag = Tag::create($input))
            Flash::push("Thêm thẻ \\\"$tag->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Thêm thẻ \\\"{$input['tag_name']}\\\" thất bại", 'Hệ thống', "error");

        return redirect(action('TagsController@index'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tag = Tag::with('posts', 'postsCount')->findOrFail($id);
        return view('admin.tag_edit', compact('tag'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Redirect
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::with('posts', 'postsCount')->findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:4',
            'slug'=> 'required|min:4|unique:tag,slug,' . $id,
        ]);

        $input = $request->input();
        if($tag->update($input))
            Flash::push("Sửa thông tin thẻ \\\"$tag->name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Sửa thông tin thẻ \\\"$tag->name\\\" thất bại", 'Hệ thống', "error");

        return redirect(action('TagsController@index'));
    }

    /**
     * @param Request $request
     * @return Redirect
     */
    public function destroy(Request $request)
    {
        $tag = Tag::findOrFail($request->request->get('tag_id'));

        $result = false;
        $tag_name = $tag->name;

        try
        {
            if(Tag::destroy($tag->id))
                $result = true;
        }
        catch(\Exception $ex)
        {
            $result = false;
        }

        if($result)
            Flash::push("Xóa thẻ \\\"$tag_name\\\" thành công", 'Hệ thống');
        else
            Flash::push("Xóa thẻ \\\"$tag_name\\\" thất bại", 'Hệ thống', "error");

        return redirect(action('TagsController@index'));
    }
}
