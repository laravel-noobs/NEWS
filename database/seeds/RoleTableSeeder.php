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
            ],
            [
                'name'=> 'Biên tập viên',
                'slug' => str_slug('Biên tập viên')
            ],
            [
                'name'=> 'Cộng tác viên',
                'slug' => str_slug('Cộng tác viên')
            ]
        ];
        DB::table('role')->insert($role);
        //
    }
}
