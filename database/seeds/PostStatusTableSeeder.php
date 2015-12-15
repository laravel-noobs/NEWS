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
                'name' => 'Pending',
                'slug' => str_slug('Pending')
            ],
            [
                'name' => 'Published',
                'slug' => str_slug('Published')
            ],

        ];
        DB::table('post_status')->insert($post_status);
    }
}
