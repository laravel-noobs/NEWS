<?php

namespace App\Http\Controllers;

use App\Events\FeedbackChecked;
use App\Feedback;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FeedbacksController extends Controller
{
    public function index(Request $request)
    {
            $feedbacks = Feedback::with([
                'post' => function($query) {
                    $query->addSelect(['id', 'title', 'slug']);
                },
                'user'
            ])->paginate(8);

            return view('admin.feedback_index', compact('feedbacks'));
    }

    public function listByPost($id)
    {
        $post = Post::with([
            'feedbacks' => function($query)
            {
                $query->orderBy('created_at', 'desc');
            },
            'feedbacks.user' => function($query)
            {
                $query->addSelect(['id', 'name']);
            },
        ])->findOrFail($id, ['id', 'title']);

        return view('admin.feedback_list_bypost', compact('post'));
    }

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
