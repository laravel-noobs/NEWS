<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\RolePermission;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivilegesController extends Controller
{
    /**
     * @var string
     */
    protected $config_key = '_privilege';

    /**
     * @var array
     */
    protected $configs = [
        'filter' => [
            'role' => null
        ]
    ];

    /**
     * @var array
     */
    protected $configs_validate = [
        'filter.role' => 'exists:role,id'
    ];

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        $this->load_config('filter');
    }

    public function index()
    {
        $is_administrator = true;
        $role_permissions = new Collection([]);

        if(!Auth::user()->isAdministrator())
        {
            $role_permissions = RolePermission::with('permission', 'role')->where('role_id', '=', Auth::user()->role_id)->get();
            $is_administrator = false;
        }

        return view('admin.privilege_index', array_merge(compact('role_permissions', 'is_administrator')));
    }

    public function grant()
    {
        $this->authorize('grantPermission');

        $configs = $this->read_configs(['filter.role']);

        if($configs['filter_role'])
            $selected_role = Role::findOrFail($configs['filter_role']);
        else
            $selected_role = Role::first();

        $permissions = Permission::with('roles')->get();

        $roles = Role::all();

        return view('admin.privilege_grant', array_merge(compact('permissions','roles', 'selected_role'), $configs));
    }

    public function grantToRole(Request $request)
    {
        $this->authorize('grantPermission');

        $this->validate($request, [
            'role_id' => 'required|exists:role,id',
            'permission_id' => 'required|exists:permission,id',
            'granted' => 'required|boolean'
        ]);

        $input = $request->input();

        $permission = Permission::findOrFail($input['permission_id']);
        $role = Role::findOrFail($input['role_id']);

        try {
            if (!$input['granted'])
                DB::delete('delete from role_permission where role_id = ? and permission_id = ?', [ $role->id, $permission->id]);
            else
                DB::insert('insert into role_permission (role_id, permission_id) values (?, ?)', [ $role->id, $permission->id]);
        } catch (QueryException $e){
            return [
                'result' => false,
                'msg' => 'Thay đổi thất bại  <br/>' . $role->label . ' : ' . $permission->name,
                'permission_name' => $permission->name,
                'role_label' => $role->name
            ];
        }
        return [
            'result' => true,
            'msg' => 'Thay đổi thành công <br/>' . $role->label . ' : ' . $permission->name,
            'permission_name' => $permission->name,
            'role_name' => $role->name,
            'role_label'=> $role->label,
            'granted' => $input['granted']
        ];
    }

}
