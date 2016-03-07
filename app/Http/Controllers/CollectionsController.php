<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use KouTsuneka\FlashMessage\Flash;

class CollectionsController extends Controller
{
    /**
     * @var string
     */
    protected $config_key = '_post';

    /**
     * @var array
     */
    protected $configs = [
        'filter' => [
            'hide_expired' => true,
            'collection_status' => 'all',
        ]
    ];

    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.hide_expired' => 'boolean',
        'filter.collection_status' => 'in:showing,hidden,all'
    ];

    /**
     * CollectionsController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('indexCollection');

        $configs = $this->read_configs(['filter.hide_expired', 'filter.collection_status']);

        $query = Collection::with(['products', 'productsCount']);

        if($configs['filter_collection_status'] == 'showing')
            $query->onlyShowing();
        else if($configs['filter_collection_status'] == 'hidden')
            $query->onlyHidden();

        if($configs['filter_hide_expired'])
            $query->notExpired();

        $collections = $query->latest()->paginate(10);

        return view('admin.shop.collection_index', array_merge(compact('collections')), $configs);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.shop.collection_create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
