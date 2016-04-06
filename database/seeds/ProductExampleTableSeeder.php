<?php

use Illuminate\Database\Seeder;
use App\ProductBrand;
use App\ProductStatus;
use App\ProductCategory;
class ProductExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = ProductBrand::all(['id']);
        $status = ProductStatus::all(['id']);
        $categories = ProductCategory::all(['id']);

        DB::table('product')->delete();
        for($i = 0; $i < 200; $i++)
        {
            factory('App\Product')->create([
                'category_id' => $categories->random()->id,
                'status_id' => $status->random()->id,
                'brand_id' => $brands->random()->id
            ]);
        }
    }
}
