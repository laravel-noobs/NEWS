<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class ProductCategoriesController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('productsCount')->orderBy('id','desc')->get();

        return view('admin.shop.product_category_index', compact('categories'));
    }

    public function store(Request $request)
    {
        dd($request);
    }

    public function destroy(Request $request)
    {
        dd($request);
    }
}
