<?php

namespace App\Http\Controllers\merchants\merchants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesMerchantController extends Controller
{
    //* Page Show Roles
    public function index(Request $request)
    {
        $roles = Role::where('guard_name', 'merchants')->orderBy('id','DESC')->paginate(5);
        return view('Dashboard_UMC.merchants.roles.index',compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    //* Page Create Role
    public function create()
    {
        $permission = Permission::get();
        return view('Dashboard_UMC.merchants.roles.create',compact('permission'));
    }

    //* Store Role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ],[
            'name.required' =>__('Dashboard/permissions.namepermissionrequired'),
            'name.unique' =>__('Dashboard/permissions.nameunique'),
            'permission.required' =>__('Dashboard/permissions.permissionrequired'),
        ]);

        try{
            DB::beginTransaction();
            $role = Role::create([
                'name' => $request->input('name'),
                'guard_name' => 'merchants'
            ]);
            $permissions = Permission::whereIn('id', $request->permission)
                ->where('guard_name', 'merchants')
                ->get();
            $role->syncPermissions($permissions);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('rolesmerchant.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('rolesmerchantmerchant.index');
        }
    }

    //* View One Role
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')
        ->where('role_has_permissions.role_id',$id)
        ->get();
        return view('Dashboard_UMC.merchants.roles.show',compact('role','rolePermissions'));
    }

    //* Page Edit Role
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id',$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('Dashboard_UMC.merchants.roles.edit',compact('role','permission','rolePermissions'));
    }

    //* Update Role
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ],[
            'name.required' =>__('Dashboard/permissions.namepermissionrequired'),
            'permission.required' =>__('Dashboard/permissions.permissionrequired'),
        ]);

        try{
            DB::beginTransaction();
            $role = Role::findOrFail($id);
            $input = $request->all();
            $b_exists = Role::where('name', '=', $input['name'])->exists();
            if($b_exists){
                $role->syncPermissions($request->input('permission'));
                DB::commit();
                toastr()->success(trans('Dashboard/messages.update'));
                return redirect()->route('rolesmerchant.index');
            }
            else{
                $role->name = $request->input('name');
                $role->save();
                $role->syncPermissions($request->input('permission'));
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('rolesmerchant.index');
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('rolesmerchant.index');
        }
    }

    //* Delete One Role
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            DB::table('roles')->where('guard_name', 'merchants')->where('id',$id)->delete();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('rolesmerchant.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('rolesmerchant.index');
        }
    }
}
