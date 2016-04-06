<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;

class OrdersController extends Controller
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
            'status_id' => null,
            'customer_name' => null,
            'order_id' => null,
            'created_at_start' => null,
            'created_at_end' => null
        ]
    ];

    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.customer_name' => 'min:4,max:255',
        'filter.order_id' => 'exists:order,id',
        'filter.status_id' => 'exists:order_status,id',
        'filter.created_at_start' => 'date_format:Y-m-d H:i:s',
        'filter.created_at_end' => 'date_format:Y-m-d H:i:s'
    ];

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }

    public function index()
    {
        $configs = $this->read_configs(['filter.order_id', 'filter.customer_name', 'filter.status_id', 'filter.created_at_start', 'filter.created_at_end']);

        $order_status = OrderStatus::all();
        $filter_status = null;
        $orders = Order::with(['status', 'user', 'products'])
            ->hasId($configs['filter_order_id'])
            ->hasStatus($configs['filter_status_id'])
            ->hasCustomer($configs['filter_customer_name'])
            ->createdFrom($configs['filter_created_at_start'])
            ->createdTo($configs['filter_created_at_end'])
            ->latest()
            ->paginate(50);
        return view('admin.shop.order_index', array_merge(compact('order_status', 'filter_status', 'orders'), $configs));
    }
}
