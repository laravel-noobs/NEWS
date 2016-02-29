<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\Post;
use App\Product;
use Illuminate\Support\Facades\DB;

class TaggableExampleSeeder extends Seeder
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
        $tags = Tag::all(['id']);

        $max = ($posts->count() + $products->count()) * $tags->count();
        $total = random_int($max * 0.01, $max * 0.03);

        echo "We have {$posts->count()} posts, {$products->count()} products and {$tags->count()} tags.\nTry to generate {$total} taggable records\n";

        DB::table('taggable')->delete();

        for($i = 0; $i < $total; $i++)
        {
            $taggable = random_int(0, 1) ? $posts[random_int(0, $posts->count() - 1)] : $products[random_int(0, $products->count() - 1)];

            try
            {
                factory('App\Taggable')->create([
                    'tag_id' => $tags[random_int(0, $tags->count() - 1)]->id,
                    'taggable_id' => $taggable->id,
                    'taggable_type' => get_class($taggable)
                ]);
            } catch (\Exception $ex){
                //echo "Duplicated record at {$i}\n";
            }
        }
    }
}
