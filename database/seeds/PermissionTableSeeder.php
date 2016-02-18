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
                    'name' => 'update',
                    'label'=> 'Permission 1',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'permission_2',
                    'label'=> 'Permission 2',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'permission_3',
                    'label'=> 'Permission 3',
                    'model' => null,
                    'policy' => null
                ]
            ];
        DB::table('permission')->insert($permissions);
    }
}
