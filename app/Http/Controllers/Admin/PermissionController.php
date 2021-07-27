<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions=Permission::latest()->paginate(20);
        return view('admin.permissions.index',compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name'=>'required',
            'name'=>'required'
        ]);

        Permission::create([
            'display_name'=>$request->display_name,
            'name'=>$request->name,
            'guard_name'=>'web'
        ]);

        alert()->success('مجوز مورد نظر ایجاد شد', 'با تشکر');

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit',compact('permission'));
    }

    public function update(Request $request , Permission $permission)
    {
        $request->validate([
            'display_name'=>'required',
            'name'=>'required'
        ]);

        $permission->update([
            'display_name'=>$request->display_name,
            'name'=>$request->name,
        ]);

        alert()->success('مجوز مورد نظر ویرایش شد', 'با تشکر');

        return redirect()->route('admin.permissions.index');
    }

}
