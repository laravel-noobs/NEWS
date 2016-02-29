<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\User;


class ProductReviewExampleTableSeeder extends Seeder
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

        DB::table('product_review')->delete();
        for($i = 0; $i < 200; $i++)
        {
            factory('App\ProductReview')->create([
                'product_id' => $products->random()->id,
                'user_id' => random_int(0,1) ? $users->random()->id : null
            ]);
        }
    }
}
