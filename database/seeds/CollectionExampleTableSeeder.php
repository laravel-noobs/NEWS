<?php

use Illuminate\Database\Seeder;

class CollectionExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Collection::class, 20)->create();
    }
}
