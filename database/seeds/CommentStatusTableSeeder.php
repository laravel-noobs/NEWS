<?php

use Illuminate\Database\Seeder;

class CommentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment_status')->delete();
        $comment_status = [
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
        DB::table('comment_status')->insert($comment_status);
    }
}
