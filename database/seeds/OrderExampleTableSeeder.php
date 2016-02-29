<?php

use Illuminate\Database\Seeder;
use App\OrderStatus;
use App\User;

class OrderExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = OrderStatus::all(['id']);
        $users = User::all(['id']);

        DB::table('order')->delete();
        for($i = 0; $i < 200; $i++)
        {
            factory('App\Order')->create([
                'status_id' => $status->random()->id,
                'user_id' => random_int(0,1) ? $users->random()->id : null
            ]);
        }
    }
}
