<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tag')->delete();
        factory(Tag::class, 200)->create();
    }
}
