<?php

use Illuminate\Database\Seeder;

class ProductStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_status')->delete();
        $post_status = [
            [
                'name' => 'outofstock',
                'label' => 'Hết hàng',
                'slug' => str_slug('Hết hàng')
            ],
            [
                'name' => 'available',
                'label' => 'Còn hàng',
                'slug' => str_slug('Còn hàng')
            ],
        ];
        DB::table('product_status')->insert($post_status);
    }
}
