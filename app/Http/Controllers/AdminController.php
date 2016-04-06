<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }

    /**
     * @param $name
     * @return array
     */
    public function permalink($name = null)
    {
        // @TODO
        if(!$name)
            abort(400);

        $slug = str_slug($name);
        $link = array('permalink'=> $slug);
        return $link;
    }
}
