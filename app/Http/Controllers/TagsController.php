<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::with(['postsCount'])->orderBy('id', 'desc')->paginate(20);
        return view('admin.tag_index', compact('tags'));
    }
    /**
     * @param string $term
     */
    public function queryTags(Request $request)
    {
        $term = $request->request->get('query');
        if(strlen($term) < 3)
            return null;
        $tag = Tag::where('name', 'LIKE', '%' . $term . '%')->get(['id', 'name']);
        return $tag;
    }

    public function store(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }
}
