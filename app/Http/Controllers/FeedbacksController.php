<?php

namespace App\Http\Controllers;

use App\Events\FeedbackChecked;
use App\Feedback;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FeedbacksController extends Controller
{
    /**
     * @var string
     */
    protected $config_key = '_feedback';

    /**
     * @var array
     */
    protected $configs = [
        'filter' => [
            'search_term' => null,
            'show_checked' => false,
            'feedbackable_type' => 'post'
        ]
    ];
    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.search_term' => 'min:4|max:255',
        'filter.show_checked' => 'boolean',
        'filter.feedbackable_type' => 'in:post,product'
    ];

    /**
     * FeedbacksController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('indexFeedback');

        $configs = $this->read_configs(['filter.show_checked', 'filter.feedbackable_type', 'filter.search_term']);

        $query = Feedback::with([
            'user' => function($query) {
                $query->addSelect(['id', 'name', 'email']);
            }
        ]);

        if(!$configs['filter_show_checked'])
            $query->notChecked();

        switch($configs['filter_feedbackable_type'])
        {
            case 'post':
                $query = $query->belongToPost();
                break;
            case 'product':
                $query = $query->belongToProduct();
                break;
        }

        $feedbacks = $query->paginate(8);

        $feedbacks->load('feedbackable');

        if($feedbacks->currentPage() != 1 && $feedbacks->count() == 0)
            return Redirect::action('FeedbacksController@index');

        return view('admin.feedback_index', array_merge(compact(['feedbacks']), $configs));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listByPost($id)
    {
        $this->authorize('indexFeedback');

        $filter_show_checked = $this->read_config('filter.show_checked');

        $post = Post::with([
            'feedbacks' => function($query) use($filter_show_checked)
            {
                if(!$filter_show_checked)
                    $query->notChecked();
                $query->orderBy('created_at', 'desc');
            },
            'feedbacks.user' => function($query)
            {
                $query->addSelect(['id', 'name', 'email']);
            },
            'feedbacks.post' => function($query)
            {
                $query->addSelect(['id', 'user_id']);
            }
        ])->findOrFail($id, ['id', 'title']);

        return view('admin.feedback_list_bypost', compact('post', 'filter_show_checked'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listByUser($id)
    {
        $this->authorize('indexFeedback');

        $filter_show_checked = $this->read_config('filter.show_checked');

        $user = User::with([
            'feedbacks' => function($query) use($filter_show_checked)
            {
                if(!$filter_show_checked)
                    $query->notChecked();
                $query->orderBy('created_at', 'desc');
            },
            'feedbacks.feedbackable',
        ])->findOrFail($id, ['id', 'name', 'email']);

        return view('admin.feedback_list_byuser', compact('user', 'filter_show_checked'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function check(Request $request)
    {
        $input = $request->input();

        $feedback = Feedback::with([
            'post' => function($query) {
                $query->addSelect(['id', 'title', 'slug']);
            },
            'user'
        ])->findOrFail($input['feedback_id']);

        if(Gate::denies('checkFeedback'))
            abort(403);

        if(!$feedback->checked)
        {
            $feedback->checked = true;
            $feedback->save();
        }

        event(new FeedbackChecked($feedback, Auth::user(), $input['message']));
        return Redirect::back();
    }
}
