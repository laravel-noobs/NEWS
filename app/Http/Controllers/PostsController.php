<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use KouTsuneka\FlashMessage\Flash;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['category', 'user', 'postStatus'])->get();
        return view('admin.post_index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::all();
        return view('admin.post_create', ['category' => $cat]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $cat_id = $input['category_id'];
        $cat = [];
        if(Category::find($cat_id) == null)
        {
            $input['category_id'] = null;
            $cat = [
                'cat_name' => $cat_id,
                'cat_slug' => str_slug($cat_id)
            ];
        }

        $tags = [];
        $new_tags = [];

        foreach($input['tags'] as $tag_id)
        {
            $tag = Tag::findOrNew($tag_id, ['id']);
            if($tag->id == null)
            {
                $tag_slug = str_slug($tag_id);
                array_push($new_tags, ['name' => $tag_id, 'slug' => $tag_slug]);
            }
            else
                array_push($tags, $tag->id);
        }

        $input = array_merge($input, $cat, ['new_tags' => $new_tags ]);

        $validator = Validator::make($input, [
            'title' => 'required|min:4',
            'slug' => 'required|min:4|unique:post,slug',
            'content' => 'required|min:40|max:2000',
            'published_at' => 'required',
            'new_tags.*.name' => 'required|min:4',
            'new_tags.*.slug'=> 'required|min:4|unique:tag,slug',
            'cat_name' => 'required_if:category_id,null|min:4',
            'cat_slug' => 'required_if:category_id,null|min:4|unique:category,slug',
        ]);

        if($validator->fails())
        {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = false;
        DB::beginTransaction();
        try
        {
            if($input['category_id'] == null)
                $cat_id = Category::create(['name' => $input['cat_name'], 'slug' => $input['cat_slug']])->id;

            $post = new Post($input);

            foreach($new_tags as $tag)
            {
                $t = Tag::create($tag);
                array_push($tags, $t->id);
            }

            $post->user_id = 1;//Auth::user()->id; // user_id = 1 for temporary development
            $post->status_id = 1;
            $post->category_id = $cat_id;
            if($post->save())
            {
                $post->tags()->attach($tags);
                DB::commit();
                $result = true;
            }
            else
            {
                DB::rollBack();
                $result = false;
            }
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            $result = false;
        }

        if($result)
            Flash::push("Thêm bài viết \\\"$post->title\\\" thành công", 'Hệ thống');
        else
            Flash::push("Thêm bài viết thất bại", 'Hệ thống', "error");

        return redirect()->action('PostsController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function permalink($name)
    {
        $slug = str_slug($name);
        $link = array('permalink'=> $slug);
        return $link;
    }
}
