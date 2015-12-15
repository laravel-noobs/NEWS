<?php

use Illuminate\Database\Seeder;

class PostExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post')->delete();
        $post = [
            [
                'title' => 'Lorem Ipsum',
                'slug' => str_slug('Lorem Ipsum'),
                'content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'view' =>10
            ]
        ];
        DB::table('post')->insert($post);
    }
}
