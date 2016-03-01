<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\URL;

class ProductsController extends Controller
{
    public function show($slug)
    {
        dd($slug);
    }

    public function queryProducts(Request $request)
    {
        // @TODO

        $term = $request->request->get('query');

        if(strlen($term) < 3)
            return null;

        $products = Product::searchInName($term)->get(['id', 'name', 'slug']);

        foreach($products as $product)
            $product->url = URL::action('ProductsController@show', ['slug' => $product->slug]);

        return $products;
    }
}
