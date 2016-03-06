<?php

namespace App\Http\Controllers;

use App\CommentStatus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use Illuminate\Support\Facades\Redirect;
use KouTsuneka\FlashMessage\Flash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentsController extends Controller
{
    /**
     * @var string
     */
    protected $config_key = '_comment';

    /**
     * @var array
     */
    protected $configs = [
        'filter' => [
            'status_type' => 'approved',
            'hide_spam' => 0,
            'search_term' => null,
            'commentable_type' => 'post'
        ]
    ];
    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.search_term' => 'min:4,max:255',
        'filter.hide_spam' => 'boolean',
        'filter.commentable_type' => 'in:post,product',
        'filter.status_type' => 'in:pending,approved,trash'
    ];

    /**
     * CommentsController constructor.
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
        $this->authorize('indexComment');

        $configs = $this->read_configs(['filter.status_type', 'filter.search_term', 'filter.hide_spam', 'filter.commentable_type']);

        $query = Comment::with([
            'status',
            'user'
        ]);

        if($configs['filter_status_type'])
            $query->hasStatus($configs['filter_status_type']);

        if($configs['filter_hide_spam'])
            $query->notSpam();

        if($configs['filter_search_term'])
            $query->searchByTerm($configs['filter_search_term']);

        switch($configs['filter_commentable_type'])
        {
            case 'post':
                $query->belongToPost();
                break;
            case 'product':
                $query->belongToProduct();
                break;
        }

        $query->orderBy('created_at','desc');

        $comments = $query->paginate(8);

        $comments->load(['commentable']);

        if($comments->currentPage() != 1 && $comments->count() == 0)
            return Redirect::action('CommentsController@index');

        return view('admin.comment_index', array_merge(compact(['comments']), $configs));
    }

    public function edit($id)
    {
        $this->authorize('updateComment');

        $comment = Comment::with([
            'status',
            'commentable',
            'user' => function($query) {
                $query->addSelect(['id', 'name']);
            }
        ])->findOrFail($id);

        $comment_status = CommentStatus::all(['id',  'label']);

        return view('admin.comment_edit', compact('comment', 'comment_status'));
    }

    public function update($id, Request $request)
    {
        $this->authorize('updateComment');

        $comment = Comment::findOrFail($id);

        $this->validate($request, [
            'user_id' => 'required_without:name,email|exists:user,id',
            'name' => 'required_without:user_id|min:4|max:20',
            'email' => 'required_without:user_id|email',
            'commentable_type' => 'required|in:App\Post,App\Product',
            'commentable_id' => 'required|' . ($request->get('commentable_type') == 'App\Post' ? 'exists:post,id' : 'exists:product,id'),
            'status_id' => 'required|exists:comment_status,id',
            'spam' => 'boolean',
            'created_at' => 'date_format:Y-m-d H:i:s'
        ]);

        $input = $request->input();
        $comment->spam = isset($input['spam']) ? true : false;
        $comment->created_at = $input['created_at'];
        $comment->commentable_type = $input['commentable_type'];
        $comment->commentable_id = $input['commentable_id'];
        $comment->status_id = $input['status_id'];
        $comment->user_id = isset($input['user_id']) ? $input['user_id'] : null;
        $comment->fill($input);

        if($comment->save())
            Flash::push("Sửa bình luận #$comment->id thành công", 'Hệ thống');
        else
            Flash::push("Sửa bình luận #$comment->id thất bại", 'Hệ thống');

        return Redirect::action('CommentsController@edit', ['id' => $comment->id]);
    }

    /**
     * @param Comment $comment_id
     * @return mixed
     */
    public function spam(Comment $comment_id)
    {
        $this->authorize('spamComment');

        if($comment_id->markAsSpam())
            Flash::push("Đánh dấu spam bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Đánh dấu spam bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Comment $comment_id
     * @return mixed
     */
    public function notspam(Comment $comment_id)
    {
        $this->authorize('unspamComment');

        if($comment_id->markAsNotSpam())
            Flash::push("Bỏ đánh dấu spam bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Bỏ đánh dấu spam bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Comment $comment_id
     * @return mixed
     */
    public function approve(Comment $comment_id)
    {
        if(Gate::denies('approveComment') && Gate::denies('approveOwnedPostComment'))
            abort(403);

        $comment_id->status_id = CommentStatus::getStatusByName('approved');
        if($comment_id->save())
            Flash::push("Duyệt bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Duyệt bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Comment $comment_id
     * @return mixed
     */
    public function unapprove(Comment $comment_id)
    {
        $this->authorize('unapproveComment');

        $comment_id->status_id = CommentStatus::getStatusByName('pending');
        $comment_id->save();
        if($comment_id->save())
            Flash::push("Bỏ duyệt bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Bỏ duyệt bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Comment $comment_id
     * @return mixed
     */
    public function trash(Comment $comment_id)
    {
        if(Gate::denies('trashComment') && Gate::denies('trashOwnedPostComment'))
            abort(403);
        $comment_id->status_id = CommentStatus::getStatusByName('trash');
        $comment_id->save();

        if($comment_id->save())
            Flash::push("Cho bình luận #$comment_id->id vào thùng rác thành công", 'Hệ thống');
        else
            Flash::push("Cho bình luận #$comment_id->id vào thùng rác thất bại", 'Hệ thống');

        return redirect()->back();
    }

    /**
     * @param Comment $comment_id
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Comment $comment_id)
    {
        $this->authorize('destroyComment');

        if($comment_id->delete())
            Flash::push("Xóa bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Xóa bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }
}
