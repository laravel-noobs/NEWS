<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolePermissionTableSeeder extends Seeder
{

    /**
     * @var
     */
    private $permissions;
    /**
     * @var
     */
    private $role;

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        DB::table('role_permission')->delete();
        $this->roles = Role::all();
        $this->permissions = Permission::all();

        $editor = $this->roles->find(Role::getRoleIdByName('editor'));

        if($editor)
        {
            DB::table('role_permission')->insert($this->getArrayPermissionsToRole($editor,[
                'accessAdminPanel',
                'indexPost',
                'listOwnedPost',
                'storePendingPost',
                'storeApprovedPost',
                'storeDraftPost',
                'storePostWithNewTag',
                'updateOwnPost',
                'approvePendingPost',
                'approveOwnDraftPost',
                'approveCollaboratorPendingPost',
                'trashOwnPost',
                'indexCategory',
                'listOwnedFeedback'
            ]));
        }

    }

    /**
     * @param $name
     * @param null $policy
     * @return mixed
     */
    private function getPermission($name, $policy = null)
    {
        return $this->permissions->where('name', $name)->pluck('id')->first();
    }

    /**
     * @param $role
     * @param $permissions
     * @return array
     * @throws Exception
     */
    private function getArrayPermissionsToRole($role, $permissions)
    {
        $role_permissions = [];
        foreach($permissions as $permission)
        {
            $p = $this->getPermission($permission);
            if(!$p)
                throw new \Exception('Invalid permission was provided');

            array_push($role_permissions,
                [
                    'role_id' => $role->id,
                    'permission_id' => $p
                ]);
        }
        return $role_permissions;
    }
}
