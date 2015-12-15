<?php

use Illuminate\Database\Seeder;

class FeedbackExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feedback')->delete();
        $feedback =
            [
                [
                    'content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                    'user_id' => 1,
                    'post_id' => 1
                ]
            ];
        DB::table('feedback')->insert($feedback);

    }
}
