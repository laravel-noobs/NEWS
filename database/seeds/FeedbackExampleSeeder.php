<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;

class FeedbackExampleSeeder extends Seeder
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
        DB::table('feedback')->delete();
        for($i = 0; $i < 500; $i++)
        {
            $feedbackable = random_int(0,1) ? $posts->random() : $products->random();
            factory('App\Feedback')->create([
                'user_id' => $users->random()->id,
                'feedbackable_id' => $feedbackable->id,
                'feedbackable_type' => get_class($feedbackable)
            ]);
        }
    }
}
