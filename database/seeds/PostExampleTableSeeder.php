<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\PostStatus;
use Illuminate\Support\Facades\DB;

class PostExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all(['id']);
        $categories = Category::all(['id']);
        $post_status = PostStatus::all(['id']);

        DB::table('post')->delete();
        for($i = 0; $i < 200; $i++)
        {
            factory('App\Post')->create([
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
                'status_id' => $post_status->random()->id
            ]);
        }
    }
}
