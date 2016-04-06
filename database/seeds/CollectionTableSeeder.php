<?php

use Illuminate\Database\Seeder;

class CollectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collection')->delete();
        $collections = [
            [
                'name' => 'featured',
                'label' => 'Sản phẩm nổi bật',
                'slug' => str_slug('Sản phẩm nổi bật'),
                'enabled' => true,
                'description' => 'Sản phẩm nổi bật nhất SHOP.',
                'image' => null,
                'expired_at' => null
            ],
            [
                'name' => 'mainSlideshow',
                'label' => 'Sản phẩm trình diễn',
                'slug' => str_slug('Sản phẩm trình diễn'),
                'enabled' => true,
                'description' => 'Mặt hàng trình diễn trên slide show trang chủ.',
                'image' => null,
                'expired_at' => null
            ]
        ];
        DB::table('collection')->insert($collections);
    }
}
