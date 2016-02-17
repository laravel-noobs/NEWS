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
                'name' => 'admin',
                'label'=> 'Quản trị viên',
                'slug' => str_slug('Quản trị viên')
            ],
            [
                'name' => 'editor',
                'label'=> 'Biên tập viên',
                'slug' => str_slug('Biên tập viên')
            ],
            [
                'name' => 'collaborator',
                'label'=> 'Cộng tác viên',
                'slug' => str_slug('Cộng tác viên')
            ]
        ];
        DB::table('role')->insert($role);
    }
}
