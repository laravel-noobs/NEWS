<?php

use Illuminate\Database\Seeder;

class UserExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->delete();
        $users = [
            [
                'name' => 'Tsuneka',
                'password' => bcrypt('abc@123'),
                'email' => 'yahishima@gmail.com',
                'first_name' => 'Kou',
                'last_name' => 'Tsuneka'
            ]
        ];
        DB::table('user')->insert($users);
    }
}
