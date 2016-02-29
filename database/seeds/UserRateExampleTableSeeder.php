<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;

class UserRateExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all(['id']);
        $users = User::all(['id']);

        $max = $products->count() * $users->count();
        $total = $max * 0.03;

        echo "We have {$products->count()} products and {$users->count()} users.\nTry to generate {$total} user rate records\n";

        DB::table('user_rate')->delete();

        for($i = 0; $i < $total; $i++)
        {
            try
            {
                factory('App\UserRate')->create([
                    'user_id' => $users[random_int(0, $users->count()-1)]->id,
                    'product_id' => $products[random_int(0, $products->count()-1)]->id
                ]);
            } catch (\Exception $ex){
                //echo "Duplicated record at {$i}\n";
            }
        }
    }
}
