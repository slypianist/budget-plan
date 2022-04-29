<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only'=>['create', 'store']]);
        $this->middleware('permission:role-edit', ['only'=>['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request){
        $roles = Role::orderBy('id', 'ASC')->get();
        return view('roles.index', compact('roles'))->with('i', ($request->input('page', 1)-1)*5);
    }

    public function create(){
      $permissions =  Permission::get();
      //dd($permissions);
        return view('roles.create', compact('permissions'));

    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required'

        ]);
//dd($request->all());
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('roles.index')->with('message', 'Role has been created');
    }

    public function show($id){
        $role = Role::findorFail();
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.id", "=", "permission_id")
                                       ->where("role_has_permissions.role_id", $id)->get();
        return view('roles.show', compact('role', 'rolePermissions'));

    }

    public function edit($id){
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));

    }

    public function update(Request $request, Role $role){
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',

        ]);

      //  dd($request->all());
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')->with('message', 'role has been updated');
    }

    public function destroy($id){
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('message', 'Role has been deleted successfully');

    }
}
