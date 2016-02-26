<?php

namespace App\Http\Controllers;

use App\RolePermission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PrivilegesController extends Controller
{
    public function index()
    {
        $is_administrator = true;
        $role_permissions = new Collection([]);


        if(!Auth::user()->isAdministrator())
        {
            $role_permissions = RolePermission::with('permission', 'role')->where('role_id', '=', Auth::user()->role_id)->get();
            $is_administrator = false;
        }

        return view('admin.privileges_index', compact('role_permissions', 'is_administrator'));
    }
}
