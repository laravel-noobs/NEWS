<?php

namespace App\Http\Controllers;

use App\OrderProduct;
use App\OrderStatus;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use KouTsuneka\FlashMessage\Flash;

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
        'order.*.quantity' => 'required|numeric|min:1|max:1000',
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'items.*.product_id' => 'required|exists:product,id',
            'items.*.quantity' => 'required|numeric|min:1|max:1000',
            'user_id' => 'exists:user,id',
            'customer_name' => 'required',
            'email' => 'required|email',
            'delivery_ward_id' => 'required|exists:ward,id',
            'delivery_address' => 'required',
            'phone' => 'required',
            'paymentMethod' => 'required|in:direct_method,card_method',
            'card_name' => 'required_if:paymentMethod,card_method',
            'card_number' => 'required_if:paymentMethod,card_method',
            'card_expiry' => 'required_if:paymentMethod,card_method|regex:/\d\d\/\d\d/',
            'card_cvc' => 'required_if:paymentMethod,card_method',
            'items' => 'required|array'
        ]);

        $input = $request->input();

        list($result, $order) = $this->storeTransaction($input);

        if($result)
        {
            $this->clearDetails();
            Flash::push("Thêm đơn đặt hàng \\\"$order->id\\\" thành công", 'Hệ thống');
        }

        else
            Flash::push("Thêm đơn đặt hàng thất bại", 'Hệ thống', "error");

        return redirect(action('OrdersController@index'));
    }

    private function storeTransaction($input)
    {
        DB::beginTransaction();
        try {

            $order = new Order($input);

            $order->status_id = OrderStatus::where('name', '=', 'pending')->firstOrFail()->id;

            if ($order->save()) {

                $details = [];

                foreach($input['items'] as $detail)
                {
                    $op = new OrderProduct();
                    $op->product_id = $detail['product_id'];
                    $op->quantity = $detail['quantity'];
                    array_push($details, $op);
                }

                $details = Collection::make($details);
                $details->load('product');

                $sync = [];
                foreach($details as $op)
                    $sync[$op->product_id] = ['quantity' => $op->quantity, 'price' => $op->product->price];

                $order->products()->sync($sync);

                DB::commit();
                return array(true, $order);
            }
            else
            {
                DB::rollBack();
                return array(false, $order);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return array(false, null);
        }
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
        $config = $this->read_config('order', true);

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

    public function clearDetails()
    {
        $this->write_config('order', [], false, true);
        return $this->detail();
    }

    public function removeDetail(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input,[
            'product_id' => 'required|exists:product,id'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->all(), 400);

        $this->read_config('order', true);

        for($i = 0; $i < count($this->configs['order']); $i++)
        {
            if($this->configs['order'][$i]['product_id'] == $input['product_id'])
            {
                array_splice($this->configs['order'], $i, 1);
                $i--;
            }
        }

        $this->write_config('order', $this->configs['order'], false, true);

        return ['return' => true];
    }
    public function updateDetails(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input,[
            'details.*.product_id' => 'required|exists:product,id',
            'details.*.quantity' => 'required|numeric|min:1|max:1000'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->all(), 400);

        $this->read_config('order', true);

        foreach($input['details'] as $detail)
        {
            for($i = 0; $i < count($this->configs['order']); $i++)
            {
                if($this->configs['order'][$i]['product_id'] == $detail['product_id'])
                {
                    array_splice($this->configs['order'], $i, 1);
                    $i--;
                }
            }
        }
        foreach($input['details'] as $detail)
        {
            $op = new OrderProduct();
            $op->product_id = $detail['product_id'];
            $op->quantity = $detail['quantity'];
            $op->load(['product', 'product.brand', 'product.status', 'product.brand', 'product.category']);
            array_push($this->configs['order'], $op);
        }

        $this->write_config('order', $this->configs['order'], false, true);

        return $this->configs['order'];
    }
    public function updateDetail(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input,[
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|numeric|min:1|max:1000'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->all(), 400);

        $this->read_config('order', true);

        for($i = 0; $i < count($this->configs['order']); $i++)
        {
            if($this->configs['order'][$i]['product_id'] == $input['product_id'])
            {
                array_splice($this->configs['order'], $i, 1);
                $i--;
            }
        }

        $op = new OrderProduct();
        $op->product_id = $input['product_id'];
        $op->quantity = $input['quantity'];
        $op->load(['product', 'product.brand', 'product.status', 'product.brand', 'product.category']);

        array_push($this->configs['order'], $op);

        $this->write_config('order', $this->configs['order'], false, true);

        return ['return' => true];
    }

    public function approve(Request $request)
    {
        $order = Order::findOrFail($request->request->get('order_id'));

        if($order->status_id != OrderStatus::getStatusIdByName('pending'))
            abort(400);

        if($order->approve())
            Flash::push("Duyệt sản phẩm \\\"$order->id\\\" thành công", 'Hệ thống');
        else
            Flash::push("Duyệt sản phẩm \\\"$order->id\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function deliver(Request $request)
    {
        $order = Order::findOrFail($request->request->get('order_id'));

        if($order->status_id != OrderStatus::getStatusIdByName('approved'))
            abort(400);

        if($order->deliver())
            Flash::push("Chuyển trạng thái giao hàng \\\"$order->id\\\" thành công", 'Hệ thống');
        else
            Flash::push("Chuyển trạng thái giao hàng \\\"$order->id\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function cancel(Request $request)
    {
        $order = Order::findOrFail($request->request->get('order_id'));

        if($order->status_id == OrderStatus::getStatusIdByName('completed') ||
            $order->status_id == OrderStatus::getStatusIdByName('canceled'))
            abort(400);

        if($order->cancel())
            Flash::push("Hủy đơn đặt hàng \\\"$order->id\\\" thành công", 'Hệ thống');
        else
            Flash::push("Hủy đơn đặt hàng \\\"$order->id\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }

    public function complete(Request $request)
    {
        $order = Order::findOrFail($request->request->get('order_id'));

        if($order->status_id != OrderStatus::getStatusIdByName('delivering'))
            abort(400);

        if($order->complete())
            Flash::push("Hoàn tất đơn đặt hàng \\\"$order->id\\\" thành công", 'Hệ thống');
        else
            Flash::push("Hoàn tất đơn đặt hàng \\\"$order->id\\\" thất bại", 'Hệ thống');

        return redirect()->back();
    }
}
