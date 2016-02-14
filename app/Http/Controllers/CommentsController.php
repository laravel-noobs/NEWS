<?php

namespace App\Http\Controllers;

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
            'search_term' => null
        ]
    ];
    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.search_term' => 'min:4,max:255',
        'filter.hide_spam' => 'boolean'
    ];

    /**
     * CommentsController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }

    public function index()
    {
        $configs = $this->read_configs(['filter.status_type', 'filter.search_term', 'filter.hide_spam']);

        $comments = Comment::with([
            'status',
            'user' => function($query) use($configs) {
                $query->addSelect(['id', 'name']);
            },
            'post' => function($query) {
                $query->addSelect(['id', 'title', 'slug']);
            }
        ]);

        $comments->hasStatus($configs['filter_status_type']);

        if($configs['filter_search_term'])
            $comments->searchByTerm($configs['filter_search_term']);

        if($configs['filter_hide_spam'])
            $comments->notSpam();

        $comments = $comments->orderBy('created_at','desc')->paginate(8);
        if($comments->currentPage() != 1 && $comments->count() == 0)
            return Redirect::action('CommentsController@index');

        return view('admin.comment_index', array_merge(compact(['comments']), $configs));
    }

    public function spam(Comment $comment_id)
    {
        $comment_id->spam = true;
        if($comment_id->save())
            Flash::push("Đánh dấu spam bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Đánh dấu spam bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }
    public function notspam(Comment $comment_id)
    {
        $comment_id->spam = false;
        if($comment_id->save())
            Flash::push("Bỏ đánh dấu spam bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Bỏ đánh dấu spam bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function approve(Comment $comment_id)
    {
        $comment_id->status_id = Comment::getStatusByName('approved');
        if($comment_id->save())
            Flash::push("Duyệt bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Duyệt bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function unapprove(Comment $comment_id)
    {
        $comment_id->status_id = Comment::getStatusByName('pending');
        $comment_id->save();
        if($comment_id->save())
            Flash::push("Bỏ duyệt bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Bỏ duyệt bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function trash(Comment $comment_id)
    {
        $comment_id->status_id = Comment::getStatusByName('trash');
        $comment_id->save();

        if($comment_id->save())
            Flash::push("Cho bình luận #$comment_id->id vào thùng rác thành công", 'Hệ thống');
        else
            Flash::push("Cho bình luận #$comment_id->id vào thùng rác thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function delete(Comment $comment_id)
    {
        if($comment_id->delete())
            Flash::push("Xóa bình luận #$comment_id->id thành công", 'Hệ thống');
        else
            Flash::push("Xóa bình luận #$comment_id->id thất bại", 'Hệ thống');

        return redirect()->back();
    }
}
