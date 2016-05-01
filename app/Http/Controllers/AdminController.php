<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Province;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function debug()
    {
        // please dont delete this for god sake :))
        return;
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
