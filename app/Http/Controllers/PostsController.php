<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostStatus;
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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['category', 'user', 'postStatus'])->paginate(20);
        return view('admin.post_index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(['id', 'name']);
        $post_status = PostStatus::all(['id', 'name']);
        $post_status_default_id = 2;
        return view('admin.post_create', ['categories' => $categories, 'post_status' => $post_status, 'post_status_default_id' => $post_status_default_id]);
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
        if(strrpos($cat_id, '*-', -strlen($cat_id)) !== FALSE)
        {
            $input['category_id'] = null;
            $cat_id = substr($cat_id, 2);
            $cat = [
                'category_name' => $cat_id,
                'category_slug' => str_slug($cat_id)
            ];
        }

        $tags = [];
        $new_tags = [];
        if(isset($input['tags']))
        {
            foreach($input['tags'] as $tag_id)
            {
                if(strrpos($tag_id, '*-', -strlen($tag_id)) !== FALSE)
                {
                    $tag_id = substr($tag_id, 2);
                    $tag_slug = str_slug($tag_id);
                    array_push($new_tags, ['name' => $tag_id, 'slug' => $tag_slug]);
                }
                else
                {
                    $tag = Tag::find($tag_id, ['id', 'name']);
                    if($tag != null)
                        array_push($tags, $tag);
                }
            }
        }

        $input = array_merge($input, $cat, ['new_tags' => $new_tags ], ['existed_tags' => $tags]);

        $validator = Validator::make($input, [
            'title' => 'required|min:4',
            'slug' => 'required|min:4|unique:post,slug',
            'content' => 'required|min:40|max:2000',
            'published_at' => 'required',
            'status_id' => 'required|exists:post_status,id',
            'category_id' => 'exists:category,id',
            'new_tags.*.name' => 'required|min:4',
            'new_tags.*.slug'=> 'required|min:4|unique:tag,slug',
            'category_name' => 'required_without:category_id|min:4',
            'category_slug' => 'required_without:category_id|min:4|unique:category,slug',
        ]);

        if($validator->fails())
        {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput($input);
        }

        $result = false;
        DB::beginTransaction();
        try
        {
            if($input['category_id'] == null)
                $cat_id = Category::create(['name' => $input['category_name'], 'slug' => $input['category_slug']])->id;

            $post = new Post($input);

            foreach($new_tags as $tag)
            {
                $t = Tag::create($tag);
                array_push($tags, $t);
            }

            $post->user_id = 1;//Auth::user()->id; // user_id = 1 for temporary development
            $post->status_id = 1;
            $post->category_id = $cat_id;
            if($post->save())
            {
                $tags_id = [];
                foreach($tags as $t)
                    array_push($tags_id, $t->id);

                $post->tags()->attach($tags_id);
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
     * @param Request $request
     * @return Redirect
     */
    public function destroy(Request $request)
    {
        $id = $request->request->get('post_id');
        if(empty($id))
            throw new BadRequestHttpException();

        try
        {
            if(Post::destroy($id))
                Flash::push("Xóa bài viết thành công", 'Hệ thống');
            else
                Flash::push("Xóa bài viết thất bại", 'Hệ thống', 'error');
        }
        catch(QueryException $ex)
        {
            Flash::push("Xóa bài viết thất bại", 'Hệ thống', 'error');
        }
        return redirect(action('PostsController@index'));
    }

    public function permalink($name)
    {
        $slug = str_slug($name);
        $link = array('permalink'=> $slug);
        return $link;
    }
}
