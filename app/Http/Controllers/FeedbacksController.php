<?php

namespace App\Http\Controllers;

use App\Events\FeedbackChecked;
use App\Feedback;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
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
            'show_checked' => false
        ]
    ];
    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.show_checked' => 'boolean'
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
    public function index(Request $request)
    {
        $filter_show_checked = $this->read_config('filter.show_checked');
        $query = Feedback::with([
            'post' => function($query) {
                $query->addSelect(['id', 'title', 'slug']);
            },
            'user'
        ]);

        if(!$filter_show_checked)
            $query->notChecked();

        $feedbacks = $query->paginate(8);

        if($feedbacks->currentPage() != 1 && $feedbacks->count() == 0)
            return Redirect::action('FeedbacksController@index');

        return view('admin.feedback_index', compact(['feedbacks', 'filter_show_checked']));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listByPost($id)
    {
        $filter_show_checked = $this->read_config('filter.show_checked');

        $post = Post::with([
            'feedbacks' => function($query) use($filter_show_checked)
            {
                if(!$filter_show_checked)
                    $query->unChecked();
                $query->orderBy('created_at', 'desc');
            },
            'feedbacks.user' => function($query)
            {
                $query->addSelect(['id', 'name', 'email']);
            },
        ])->findOrFail($id, ['id', 'title']);

        return view('admin.feedback_list_bypost', compact('post', 'filter_show_checked'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listByUser($id)
    {
        $filter_show_checked = $this->read_config('filter.show_checked');

        $user = User::with([
            'feedbacks' => function($query) use($filter_show_checked)
            {
                if(!$filter_show_checked)
                    $query->notChecked();
                $query->orderBy('created_at', 'desc');
            },
            'feedbacks.post' => function($query)
            {
                $query->addSelect(['id', 'title']);
            },
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

        if(!$feedback->checked)
        {
            $feedback->checked = true;
            $feedback->save();
        }

        event(new FeedbackChecked($feedback, Auth::user(), $input['message']));
        return Redirect::back();
    }
}
