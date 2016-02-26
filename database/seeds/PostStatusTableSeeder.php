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
                'name' => 'draft',
                'label' => 'Nháp',
                'slug' => str_slug('Nháp')
            ],
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
                'name' => 'trash',
                'label' => 'Rác',
                'slug' => str_slug('Rác')
            ]
        ];
        DB::table('post_status')->insert($post_status);
    }
}
