<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Tag;
use App\PostStatus;
use App\User;
use App\CommentStatus;
use App\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(UserExampleTableSeeder::class);

        $this->call(CategoryTableSeeder::class);
        $this->call(PostStatusTableSeeder::class);
        $this->call(CommentStatusTableSeeder::class);
        $this->call(TagExampleTableSeeder::class);

        $users = User::all(['id']);
        $post_status = PostStatus::all(['id']);
        $categories = Category::all(['id']);
        $tag = Tag::all(['id']);
        $comment_status = CommentStatus::all(['id']);

        $posts = [];

        DB::table('post')->delete();
        for($i = 0; $i < 200; $i++)
        {
            $post = factory('App\Post')->make([
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
                'status_id' => $post_status->random()->id
            ]);
            $post->save();
            $posts[] = $post->id;
        }
        echo "Seeded: Posts\n";

        $comments = [];
        DB::table('comment')->delete();
        for($i = 0; $i < 200; $i++)
        {
            $chance = random_int(0,100);
            $attributes = [
                'post_id' => $posts[random_int(0, count($posts)-1)],
                'status_id' => $comment_status->random()->id
            ];
            if($chance <= 20)
                $attributes = array_merge($attributes, ['user_id' =>  $users->random()->id, 'name' => null, 'email' => null]);

            $comment = factory('App\Comment')->make($attributes);
            $comment->save();
            $comments[] = $comment->id;
        }
        echo "Seeded: Comments\n";

        $feedbacks = [];
        DB::table('feedback')->delete();
        for($i = 0; $i < 50; $i++)
        {
            $feedback = factory('App\Feedback')->make([
                'user_id' => $users->random()->id,
                'post_id' => $posts[random_int(0, count($posts)-1)]
            ]);
            $feedback->save();
        }
        echo "Seeded: Feedbacks\n";


        $post_tags = [];
        DB::table('post_tag')->delete();
        for($i = 0; $i < 50; $i++)
        {
            $tag_id = $tag->random()->id;
            $post_id = $posts[random_int(0, count($posts)-1)];
            if(!isset($post_tags['_'.$post_id]) || !array_has($post_tags['_'.$post_id], $tag_id))
            {
                if(!isset($post_tags['_'.$post_id]))
                    $post_tags['_'.$post_id] = [];
                $post_tag = factory('App\PostTag')->make([
                    'tag_id' => $tag_id,
                    'post_id' => $post_id
                ]);
                $post_tags['_'.$post_id][] = $tag_id;
                $post_tag->save();
            }
            else
                $i--;
        }
        echo "Seeded: PostTag\n";

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Model::reguard();
    }
}
