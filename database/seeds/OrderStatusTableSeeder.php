<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_status')->delete();
        $post_status = [
            [
                'name' => 'pending',
                'label' => 'Đợi duyệt',
                'slug' => str_slug('Đợi duyệt')
            ],
            [
                'name' => 'approved',
                'label' => 'Đã duyệt',
                'slug' => str_slug('Đã duyệt')
            ],
            [
                'name' => 'delivering',
                'label' => 'Đang giao',
                'slug' => str_slug('Đang giao')
            ],
            [
                'name' => 'canceled',
                'label' => 'Đã hủy',
                'slug' => str_slug('Đã hủy')
            ],
            [
                'name' => 'completed',
                'label' => 'Hoàn tất',
                'slug' => str_slug('Hoàn tất')
            ]
        ];
        DB::table('order_status')->insert($post_status);
    }
}
