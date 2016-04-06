<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Order;
use Illuminate\Support\Facades\DB;

class OrderProductExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all(['id']);
        $orders = Order::all(['id']);

        $max = $products->count() * $orders->count();
        $total = random_int($max * 0.015, $max * 0.03);

        echo "We have {$products->count()} products and {$orders->count()} orders.\nTry to generate {$total} order product records\n";

        DB::table('order_product')->delete();

        for($i = 0; $i < $total; $i++)
        {
            try
            {
                factory('App\OrderProduct')->create([
                    'order_id' => $orders[random_int(0, $orders->count()-1)]->id,
                    'product_id' => $products[random_int(0, $products->count()-1)]->id
                ]);
            } catch (\Exception $ex){
                //echo "Duplicated record at {$i}\n";
            }
        }
    }
}
