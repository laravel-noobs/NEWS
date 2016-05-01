<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Role;
use App\Ward;

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
        $wards = Ward::all(['id']);

        DB::table('user')->delete();
        $users = [
            [
                'name' => 'Tsuneka',
                'password' => bcrypt('abc@123'),
                'email' => 'yahishima@gmail.com',
                'first_name' => 'Kou',
                'last_name' => 'Tsuneka',
                'role_id' => 1,
                'verified' => true,
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp
            ],
            [
                'name' => 'Administrator',
                'password' => bcrypt('abc@123'),
                'email' => 'administrator@meongu.net',
                'first_name' => 'Administrator',
                'last_name' => 'System',
                'role_id' => $roles->first()->id,
                'verified' => true,
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp
            ]
        ];
        DB::table('user')->insert($users);
        foreach($roles as $role)
        {
            $ward = $wards->random(); // kinda stupid but not really need to
            factory('App\User', 15)->create([
                'role_id' => $role->id,
                'delivery_ward_id' => $ward->id
            ]);
        }
    }
}
