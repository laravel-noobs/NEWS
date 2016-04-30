<?php

namespace App\Http\Controllers;

use App\OrderProduct;
use App\OrderStatus;
use Illuminate\Database\Eloquent\Collection;
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
        ],
        'order' => [

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
        'filter.created_at_end' => 'date_format:Y-m-d H:i:s',
        'order.*.product_id' => 'required|exists:product,id',
        'order.*.quantity' => 'required|min:1|max:10000',
    ];

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->load_configs();
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

    public function create()
    {
        $order_product = $this->getOrderDetail();

        return view('admin.shop.order_create', compact('order_product'));
    }

    public function detail()
    {
        return $this->getOrderDetail();
    }

    private function getOrderDetail()
    {
        $config = $this->read_config('order');

        $list = [];
        foreach($config as $order)
            $list[$order['product_id']] = isset($list[$order['product_id']]) ? $list[$order['product_id']] + $order['quantity'] : $order['quantity'];

        $order_product = [];

        foreach($list as $k => $v)
        {
            $op = new OrderProduct();
            $op->product_id = $k;
            $op->quantity = $v;
            array_push($order_product, $op);
        }
        $order_product = new Collection($order_product);
        $order_product->load(['product', 'product.brand', 'product.status', 'product.brand', 'product.category']);

        return $order_product;
    }
}
