<?php

namespace App\Http\Controllers;

use App\RolePermission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PrivilegesController extends Controller
{
    public function index()
    {
        $role_permissions = RolePermission::with('permission', 'role')->where('role_id', '=', Auth::user()->role_id)->get();
        return view('admin.privileges_index', compact('role_permissions'));
    }
}
