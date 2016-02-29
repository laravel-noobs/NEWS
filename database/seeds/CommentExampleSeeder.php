<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Product;
use App\Post;
use App\CommentStatus;
use Illuminate\Support\Facades\DB;

class CommentExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all(['id']);
        $products = Product::all(['id']);
        $users = User::all(['id']);
        $status = CommentStatus::all(['id']);

        DB::table('comment')->delete();
        for($i = 0; $i < 100; $i++)
        {
            $chance = random_int(0,100);
            $commentable = random_int(0,1) ? $posts->random() : $products->random();
            $attributes = [
                'commentable_id' => $commentable->id,
                'commentable_type' => get_class($commentable),
                'status_id' => $status->random()->id
            ];

            if($chance <= 20)
                $attributes = array_merge($attributes, ['user_id' =>  $users->random()->id, 'name' => null, 'email' => null]);

            factory('App\Comment')->create($attributes);
        }
    }
}
