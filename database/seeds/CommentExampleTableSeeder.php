<?php

use Illuminate\Database\Seeder;

class CommentExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment')->delete();
        factory(Comment::class, 10)->create();
    }
}
