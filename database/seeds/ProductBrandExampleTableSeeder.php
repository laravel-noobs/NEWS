<?php

use Illuminate\Database\Seeder;

class ProductBrandExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('product_brand')->delete();
        $post_status = [
            [
                'name' => 'Bayer',
                'label' => 'Bayer',
                'slug' => str_slug('Bayer'),
                'description' => null
            ],
            [
                'name' => 'Davinci',
                'label' => 'Davinci - USA',
                'slug' => str_slug('Davinci - USA'),
                'description' => 'Xuất xứ cambodia'
            ],
            [
                'name' => 'Ivory Caps',
                'label' => 'Ivory Caps',
                'slug' => str_slug('Ivory Caps'),
                'description' => null
            ],
            [
                'name' => "Puritan's Pride",
                'label' => "Puritan's Pride",
                'slug' => str_slug("Puritan's Pride"),
                'description' => null
            ],
            [
                'name' => 'STAR COMBO',
                'label' => 'STAR COMBO - ÚC',
                'slug' => str_slug('STAR COMBO - ÚC'),
                'description' => null
            ]
        ];
        DB::table('product_brand')->insert($post_status);
    }
}
