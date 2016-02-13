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
                'name' => 'Đợi duyệt',
                'slug' => str_slug('Đợi duyệt')
            ],
            [
                'name' => 'Đã duyệt',
                'slug' => str_slug('Đã duyệt')
            ],
            [
                'name' => 'Rác',
                'slug' => str_slug('Rác')
            ]
        ];
        DB::table('comment_status')->insert($comment_status);
    }
}
