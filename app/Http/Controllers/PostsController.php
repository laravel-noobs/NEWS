<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostStatus;
use App\Tag;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use KouTsuneka\FlashMessage\Flash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PostsController extends Controller
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
            'status_type' => 'approved',
            'category' => null,
            'search_term' => null
        ]
    ];

    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.search_term' => 'min:4,max:255',
        'filter.category' => 'exists:category,id'
    ];

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }

    /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function index()
    {
        $this->authorize('indexPost');

        $configs = $this->read_configs(['filter.status_type', 'filter.category', 'filter.search_term']);

        $posts = Post::with(['category', 'user', 'status', 'feedbacksCount', 'commentsCount'])
            ->hasStatus($configs['filter_status_type']);

        if($configs['filter_category'] != '')
            $posts->hasCategory($configs['filter_category']);

        $term = trim($configs['filter_search_term']);

        if($term != '' && strlen($term) >= 4)
            $posts->hasTitleContains($term);

        $posts = $posts->paginate(20);

        if($posts->currentPage() != 1 && $posts->count() == 0)
            return Redirect::action('PostController@index');

        $categories = Category::all(['id', 'name']);

        return view('admin.post_index', array_merge(compact('posts', 'categories'), $configs));
    }

    public function listByAuthenticated()
    {
        $this->authorize('listOwnedPost');

        return $this->listByUser(Auth::user()->id);
    }

    protected function listByUser($id)
    {
        $user = User::findOrFail($id);

        $configs = $this->read_configs(['filter.status_type', 'filter.category', 'filter.search_term']);

        $posts = Post::with(['category', 'user', 'status', 'feedbacksCount', 'commentsCount'])
            ->hasStatus($configs['filter_status_type'])->ownedBy($id);

        if($configs['filter_category'] != '')
            $posts->hasCategory($configs['filter_category']);

        $term = trim($configs['filter_search_term']);

        if($term != '' && strlen($term) >= 4)
            $posts->hasTitleContains($term);

        $posts = $posts->paginate(20);

        if($posts->currentPage() != 1 && $posts->count() == 0)
            return Redirect::action('PostController@listByUser', ['id' => $id]);

        $categories = Category::all(['id', 'name']);

        return view('admin.post_index', array_merge(compact('posts', 'categories', 'user'), $configs));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('storePending', new Post) && Gate::denies('storeApproved', new Post) && Gate::denies('storeTrash', new Post))
            abort(403);

        $post_status_default_id = 2;

        $categories = Category::all(['id', 'name']);
        $post_status = PostStatus::all(['id', 'name']);
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

        if(Gate::denies('storePending', [new Post, $input['status_id']]))
            abort(403);

        if(Gate::denies('storeApprovedPost', [new Post, $input['status_id']]))
            abort(403);

        if(Gate::denies('storeDraftPost', [new Post, $input['status_id']]))
            abort(403);

        if(Gate::denies('storeTrashPost', [new Post, $input['status_id']]))
            abort(403);

        list($input, $tags, $new_tags) = $this->prepareInput($input);

        if(Gate::denies('storePostWithNewCategory') && (!empty($input['category_name']) || !!empty($input['category_slug'])))
            abort(403);

        if(Gate::denies('storePostWithNewTag') && !empty($new_tags))
            abort(403);

        $validator = Validator::make($input, [
            'title' => 'required|min:4',
            'slug' => 'required|min:4|unique:post,slug',
            'content' => 'required|min:40|max:2000',
            'published_at' => 'required|date_format:Y-m-d H:i:s',
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


        list($result, $post) = $this->createTransaction($input, $new_tags, $tags);

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
        $this->authorize('updatePost');

        $post = Post::with([
            'status',
            'user' => function($query) {
                $query->addSelect(['id', 'name']);
            },
            'tags' => function($query) {
                $query->addSelect(['id', 'name']);
            }
        ])->findOrFail($id);

        $categories = Category::all(['id', 'name']);
        $post_status = PostStatus::all(['id', 'name']);
        $post_status_default_id = 2;

        return view('admin.post_edit', compact(['post', 'categories','post_status','post_status_default_id']));
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
        $post = Post::findOrFail($id);
        $input = $request->all();

        if(Gate::denies('updatePost') && Gate::denies('updateOwn', $post))
            abort(403);

        if(Gate::denies('updatePostStatus') && array_has($input, 'status_id'))
            abort(403);

        list($input, $tags, $new_tags) = $this->prepareInput($input);

        if(Gate::denies('updatePostWithNewCategory') && (!empty($input['category_name']) || !!empty($input['category_slug'])))
            abort(403);

        if(Gate::denies('updatePostWithNewTag') && !empty($new_tags))
            abort(403);

        $validator = Validator::make($input, [
            'title' => 'required|min:4',
            'slug' => 'required|min:4|unique:post,slug,' . $id,
            'content' => 'required|min:40|max:2000',
            'published_at' => 'required|date_format:Y-m-d H:i:s',
            'status_id' => 'exists:post_status,id',
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

        list($result, $post) = $this->updateTransaction($post, $input, $new_tags, $tags);

        if($result)
            Flash::push("Sửa bài viết \\\"$post->title\\\" thành công", 'Hệ thống');
        else
            Flash::push("Sửa bài viết thất bại", 'Hệ thống', "error");

        return redirect()->back();
    }

    /**
     * @param Post $post_id
     * @return mixed
     */
    public function approve(Post $post_id)
    {
        $this->authorize('approvePost');

        $post_id->status_id = PostStatus::getStatusIdByName('approved');
        if($post_id->save())
            Flash::push("Duyệt bài viết \\\"$post_id->title\\\" thành công", 'Hệ thống');
        else
            Flash::push("Duyệt bài viết \\\"$post_id->title\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Post $post_id
     * @return mixed
     */
    public function unapprove(Post $post_id)
    {
        $this->authorize('unapprovePost');

        $post_id->status_id = PostStatus::getStatusIdByName('pending');
        $post_id->save();
        if($post_id->save())
            Flash::push("Bỏ duyệt bài viết \\\"$post_id->title\\\" thành công", 'Hệ thống');
        else
            Flash::push("Bỏ duyệt bài viết \\\"$post_id->title\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Post $post_id
     * @return mixed
     */
    public function trash(Post $post_id)
    {
        if(Gate::denies('trashPost') && Gate::denies('trashOwn', $post_id))
            abort(403);

        $post_id->status_id = PostStatus::getStatusIdByName('trash');
        $post_id->save();

        if($post_id->save())
            Flash::push("Cho bài viết \\\"$post_id->title\\\" vào thùng rác thành công", 'Hệ thống');
        else
            Flash::push("Cho bài viết \\\"$post_id->title\\\" vào thùng rác thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Redirect
     */
    public function destroy(Request $request)
    {
        $this->authorize('destroyPost');

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

    /**
     * @param $name
     * @return array
     */
    public function permalink($name)
    {
        // @TODO

        $slug = str_slug($name);
        $link = array('permalink'=> $slug);
        return $link;
    }

    /**
     * @param Request $request
     * @return null
     */
    public function queryPostsByTitle(Request $request)
    {
        // @TODO

        $term = $request->request->get('query');
        if(strlen($term) < 3)
            return null;

        $posts = Post::hasTitleContains($term)->get(['id', 'title', 'slug']);

        foreach($posts as $post)
            $post->url = URL::action('PostsController@show', ['id' => $post->id]);

        return $posts;
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

    /**
     * @param $cat_id
     * @param $input
     * @return array
     */
    protected function determineCategory($cat_id, $input)
    {
        $cat = [];
        if (strrpos($cat_id, '*-', -strlen($cat_id)) !== FALSE) {
            $input['category_id'] = null;
            $cat_id = substr($cat_id, 2);
            $cat = [
                'category_name' => $cat_id,
                'category_slug' => str_slug($cat_id)
            ];
        }
        return array($cat, $input);
    }

    /**
     * @param $input
     * @return array
     */
    protected function prepareInput($input)
    {
        list($cat, $input) = $this->determineCategory($input['category_id'], $input);

        list($tags, $new_tags, $input) = $this->determineTags($input);

        $input = array_merge($input, $cat, ['new_tags' => $new_tags], ['existed_tags' => $tags]);

        return array($input, $tags, $new_tags);
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
     * @param $new_tags
     * @param $tags
     * @return array
     */
    protected function updateTransaction($post, $input, $new_tags, $tags)
    {
      DB::beginTransaction();
        try {
            if ($input['category_id'] == null)
                $input['category_id'] = Category::create(['name' => $input['category_name'], 'slug' => $input['category_slug']])->id;

            $this->createNewTags($new_tags, $tags);

            $post->user_id = \Auth::user()->id;
            if(array_has($input,'status_id'))
                $post->status_id = $input['status_id'];
            $post->category_id =  $input['category_id'];
            $post->fill($input);

            if ($post->save()) {
                $post->tags()->sync(collect($tags)->pluck('id')->all());

                DB::commit();
                return array(true, $post);
            }
            else
            {
                DB::rollBack();
                return array(false, $post);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return array(false, null);
        }
    }

    /**
     * @param $input
     * @param $new_tags
     * @param $tags
     * @return array
     */
    protected function createTransaction($input, $new_tags, $tags)
    {
        DB::beginTransaction();
        try {
            if ($input['category_id'] == null)
                $input['category_id'] = Category::create(['name' => $input['category_name'], 'slug' => $input['category_slug']])->id;

            $post = new Post($input);

            $this->createNewTags($new_tags, $tags);

            $post->user_id = \Auth::user()->id;
            $post->status_id = $input['status_id'];
            $post->category_id =  $input['category_id'];

            if ($post->save()) {
                $post->tags()->attach(collect($tags)->pluck('id')->all());
                DB::commit();
                return array(true, $post);
            }
            else
            {
                DB::rollBack();
                return array(false, $post);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return array(false, null);
        }
    }
}
