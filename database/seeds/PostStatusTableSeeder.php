<?php

use Illuminate\Database\Seeder;

class PostStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_status')->delete();
        $post_status = [
            [
                'name' => 'Đợi duyệt',
                'slug' => str_slug('Đợi duyệt')
            ],
            [
                'name' => 'Đã duyệt',
                'slug' => str_slug('Đã duyệt')
            ],
            [
                'name' => 'Đã đăng',
                'slug' => str_slug('Đã đăng')
            ],
            [
                'name' => 'Rác',
                'slug' => str_slug('Rác')
            ]
        ];
        DB::table('post_status')->insert($post_status);
    }
}
