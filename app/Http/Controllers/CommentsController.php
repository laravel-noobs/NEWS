<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use Illuminate\Support\Facades\Redirect;

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

        $comments = $comments->paginate(8);
        if($comments->currentPage() != 1 && $comments->count() == 0)
            return Redirect::action('CommentsController@index');

        return view('admin.comment_index', array_merge(compact(['comments']), $configs));
    }
}
