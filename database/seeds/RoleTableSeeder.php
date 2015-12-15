<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->delete();
        $role =
        [
            [
                'name'=> 'Admin',
                'slug' => str_slug('Admin')
            ]
        ];
        DB::table('role')->insert($role);
        //
    }
}
