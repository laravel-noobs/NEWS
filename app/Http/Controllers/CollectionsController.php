<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use KouTsuneka\FlashMessage\Flash;

class CollectionsController extends Controller
{
    public function index()
    {
        $this->authorize('indexCollection');

        $collections = Collection::with(['products', 'productsCount']);

        $collections = $collections->latest()->paginate(10);

        return view('admin.shop.collection_index', compact('collections'));
    }

    public function create()
    {
        return view('admin.shop.collection_create');
    }

    public function store(Request $request)
    {
        $this->authorize('storeCollection');

        $slug = $request->request->get('slug');
        $name = $request->request->get('label');
        if(empty($slug) && !empty($name))
        {
            $slug = str_slug($request->request->get('label'));
            if(strlen($slug) >= 4)
                $request->request->set('slug', $slug);
        }

        $this->validate($request, [
            'name' => 'required|min:4|max:255|unique:collection,name|alpha_dash',
            'label' => 'required|min:4|max:255',
            'slug' => 'required|min:4|max:255|unique:collection,slug|alpha_dash',
            'description' => 'min:6|max:1000',
            'image' => 'url|max:255',
            'enabled' => 'required|boolean',
            'expired_at' => 'date_format:Y-m-d H:i:s'
        ]);

        $input = $request->all();

        $collection = new Collection($input);
        $collection->enabled = $input['enabled'];
        $collection->expired_at = !empty($input['expired_at']) ? $input['expired_at'] : null;

        if($collection->save())
            Flash::push("Thêm nhóm sản phẩm \\\"$collection->label\\\" thành công", 'Hệ thống');
        else
            Flash::push("Thêm nhóm sản phẩm \\\"$collection->label\\\" thất bại", 'Hệ thống', "error");

        return redirect()->action('CollectionsController@index');
    }
}
