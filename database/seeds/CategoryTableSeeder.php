<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->delete();

        $phap_luat_id = DB::table('category')->insertGetId([
            'name' => 'Pháp Luật',
            'slug' => str_slug('Pháp Luật'),
            'description' => "Tin tức liên quan đến pháp luật"
        ]);
        $du_lich_id = DB::table('category')->insertGetId([
            'name' => 'Du Lịch',
            'slug' => str_slug('Du Lịch'),
            'description' => "Tin tức liên quan đến du lịch"
        ]);


        $category = [
            [
                'name' => 'Hình Sự',
                'slug' => str_slug('Hình Sự'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => $phap_luat_id
            ],
            [
                'name' => 'Đời Sống',
                'slug' => str_slug('Đời Sống'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ",
                'parent_id' => null
            ],
            [
                'name' => 'Du Lịch Trong Nước',
                'slug' => str_slug('Du Lịch Trong Nước'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => $du_lich_id
            ],
            [
                'name' => 'Du Lịch Nước Ngoài',
                'slug' => str_slug('Du Lịch Nước Ngoài'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => $du_lich_id
            ],
            [
                'name' => 'Giáo Dục',
                'slug' => str_slug('Giáo Dục'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ",
                'parent_id' => null
            ],
            [
                'name' => 'Sức Khỏe',
                'slug' => str_slug('Sức Khỏe'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => null
            ],
            [
                'name' => 'Kinh Doanh',
                'slug' => str_slug('Kinh Doanh'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => null
            ]
        ];
        DB::table('category')->insert($category);
    }
}
