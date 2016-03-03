<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CollectionsController extends Controller
{
    public function index()
    {
        $collections = Collection::with(['products', 'productsCount']);

        $collections = $collections->latest()->paginate(10);

        return view('admin.shop.collection_index', compact('collections'));
    }
}
