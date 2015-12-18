<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Role;

class UserExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();

        DB::table('user')->delete();
        $users = [
            [
                'name' => 'Tsuneka',
                'password' => bcrypt('abc@123'),
                'email' => 'yahishima@gmail.com',
                'first_name' => 'Kou',
                'last_name' => 'Tsuneka',
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp
            ],
            [
                'name' => 'Administrator',
                'password' => bcrypt('abc@123'),
                'email' => 'administrator@gmail.com',
                'first_name' => 'Administrator',
                'last_name' => 'System',
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp
            ]
        ];
        DB::table('user')->insert($users);
        factory('App\User', 20)->create([
            'role_id' => $roles->random()->id
        ]);
    }
}
