<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles=Role::latest()->paginate(20);
        return view('admin.roles.index',compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name'=>'required',
            'name'=>'required'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'display_name'=>$request->display_name,
                'name'=>$request->name,
                'guard_name'=>'web'
            ]);

            $permissions = $request->except('_token','display_name','name');
            $role->givePermissionTo($permissions);

            DB::commit();

        }catch(\Exception $ex){
            DB::rollBack();
            alert()->error($ex->getMessage(),'مشکل در ایجاد نقش')->persistent('متوجه شدم');
            return redirect()->back();
        }

        alert()->success('نقش مورد نظر ایجاد شد', 'با تشکر');
        return redirect()->route('admin.roles.index');

    }

    public function show(Role $role)
    {
        return view('admin.roles.show',compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

    public function update(Request $request , Role $role)
    {
        $request->validate([
            'display_name'=>'required',
            'name'=>'required'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'display_name'=>$request->display_name,
                'name'=>$request->name,
            ]);
            $permissions = $request->except('_token','_method','display_name','name');
            $role->syncPermissions($permissions);

            DB::commit();

        }catch(\Exception $ex){
            DB::rollBack();
            alert()->error($ex->getMessage(),'مشکل در ویرایش نقش')->persistent('متوجه شدم');
            return redirect()->back();
        }

        alert()->success('نقش مورد نظر ویرایش شد', 'با تشکر');
        return redirect()->route('admin.roles.index');
    }
}
