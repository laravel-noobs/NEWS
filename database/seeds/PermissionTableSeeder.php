<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->delete();
        $permissions =
            [
                [
                    'name' => 'permission_1',
                    'label'=> 'Permission 1'
                ],
                [
                    'name' => 'permission_2',
                    'label'=> 'Permission 2'
                ],
                [
                    'name' => 'permission_3',
                    'label'=> 'Permission 3'
                ]
            ];
        DB::table('permission')->insert($permissions);
    }
}
