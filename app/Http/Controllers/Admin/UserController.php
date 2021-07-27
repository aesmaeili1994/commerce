<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class UserController extends Controller
{
      public function index()
    {
        $users= User::latest()->paginate(20);
        return view('admin.users.index',compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.edit',compact('user','roles','permissions'));
    }

    public function update(Request $request, User $user)
    {

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'cellphone' => $request->cellphone
            ]);

            $user->syncRoles($request->role);

            $permissions = $request->except('_token','_method','name','cellphone','role');
            $user->syncPermissions($permissions);

            DB::commit();

        }catch(\Exception $ex){
            DB::rollBack();
            alert()->error($ex->getMessage(),'مشکل در ویرایش کاربر')->persistent('متوجه شدم');
            return redirect()->back();
        }

        alert()->success('کاربر مورد نظر ویرایش شد','باتشکر');
        return redirect()->route('admin.users.index');
    }
}
