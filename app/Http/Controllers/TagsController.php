<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

class TagsController extends Controller
{
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
}
