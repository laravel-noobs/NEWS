<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolePermissionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
//        DB::table('role_permission')->delete();
//        $roles = Role::all();
//        $permissions = Permission::all();
//
//        if($roles->count() < 3 || $permissions->count() < 3)
//            throw new \Exception();
//
//        DB::table('role_permission')->insert([
//            [
//                'role_id' => 1,
//                'permission_id' => 1
//            ],
//            [
//                'role_id' => 1,
//                'permission_id' => 2
//            ],
//            [
//                'role_id' => 1,
//                'permission_id' => 3
//            ],
//            [
//                'role_id' => 2,
//                'permission_id' => 2
//            ],
//            [
//                'role_id' => 2,
//                'permission_id' => 3
//            ],
//            [
//                'role_id' => 3,
//                'permission_id' => 3
//            ]
//        ]);

//        $roles[0]->givePermission($permissions[0]);
//        $roles[0]->givePermission($permissions[1]);
//        $roles[0]->givePermission($permissions[2]);
//        $roles[1]->givePermission($permissions[1]);
//        $roles[1]->givePermission($permissions[2]);
//        $roles[2]->givePermission($permissions[2]);

    }
}
