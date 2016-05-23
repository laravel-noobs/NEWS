<?php

use Illuminate\Database\Seeder;
use App\Collection;
use App\Product;
class ProductCollectionExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all(['id']);

        $collections = Collection::all(['id']);

        $max = $products->count() * $collections->count();
        $total = random_int($max * 0.1, $max * 0.5);

        echo "We have {$products->count()} products and {$collections->count()} collections.\nTry to generate {$total} product collection records\n\n";

        DB::table('product_collection')->delete();

        for($i = 0; $i < $total; $i++)
        {
            try
            {
                factory('App\ProductCollection')->create([
                    'product_id' => $products[random_int(0, $products->count() - 1)]->id,
                    'collection_id' => $collections[random_int(0, $collections->count() - 1)]->id,
                ]);
            } catch (\Exception $ex){
                //echo "Duplicated record at {$i}\n";
            }
        }
    }
}
