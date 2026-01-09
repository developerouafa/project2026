<?php

namespace App\Http\Controllers\users\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\HttpCache\Store;

class UserController extends Controller
{
    //* Page Show Users (Except the user who is logged in) & (Except for the Super Admin)
    public function index(Request $request)
    {
        $users = User::orderBy('id','DESC')->whereNot('id', '1')->where('id', '!=', Auth::user()->id)->paginate(5);
        return view('Dashboard_UMC.users.users.show_users',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    //* Create New User
    public function create()
    {
        $roles = Role::where('guard_name', 'web')->pluck('name','name')->all();
        return view('Dashboard_UMC.users.users.Add_user',compact('roles'));
    }

    //* Store User
    public function store(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();
                $user = User::create([
                    'name' => ['en' => $request->nameen, 'ar' => $request->namear],
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'account_state' => $request->account_state,
                    'password' => Hash::make($request->password)
                ]);
                $user->assignRole($request->input('roles_name'));
            // DB::commit();
            toastr()->success(__('Dashboard/messages.add'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.index');
        }
    }

    //* Show One User
    public function show($id)
    {
        $user = User::find($id);
        return view('Dashboard_UMC.users.users.show',compact('user'));
    }

    //* Page Edit User
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::where('guard_name', 'web')->pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('Dashboard_UMC.users.users.edit',compact('user','roles','userRole'));
    }

    //* Update User
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:password_confirmation',
            'roles' => 'required',
            'name' => 'required',
            ],[
                'email.required' =>__('Dashboard/users.emailrequired'),
                'email.unique' =>__('Dashboard/users.emailunique'),
                'password.same' =>__('Dashboard/users.passwordsame'),
                'roles.required' =>__('Dashboard/users.rolesnamerequired'),
                'name.required' => __('Dashboard/users.namerequired')
            ]);

        try{
            DB::beginTransaction();

                $user = User::find($id);
                $password = $user->password;

                    if(!empty($input['password'])){
                        $user->update([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'account_state' => $request->account_state,
                            'password' => Hash::make($request->password),
                        ]);
                    }else{
                        $user->update([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'account_state' => $request->account_state,
                            'password' => $password,
                        ]);
                    }

                DB::table('model_has_roles')->where('model_id',$id)->delete();
                $user->assignRole($request->input('roles'));

            DB::commit();
            toastr()->success(__('Dashboard/messages.edit'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.index');
        }
    }

    public function destroy(Request $request)
    {
        //! Delete One Request
        if($request->page_id==1){
            try{
                $id = $request->user_id;
                $tableimageuser = User::where('id',$id)->first();
                if(!empty($tableimageuser->image)){
                    if ($tableimageuser->image && Storage::disk('public')->exists($tableimageuser->image)) {
                        Storage::disk('public')->delete($tableimageuser->image);
                    }
                }
                DB::beginTransaction();
                    User::find($id)->delete();
                DB::commit();
                toastr()->success(__('Dashboard/messages.delete'));
                return redirect()->route('users.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('users.index');
            }
        }
        //! Delete One SoftDelete
        if($request->page_id==3){
            try{
                $id = $request->user_id;
                $tableimageuser = User::where('id',$id)->first();
                DB::beginTransaction();
                if(!empty($tableimageuser->image)){
                    if ($tableimageuser->image && Storage::disk('public')->exists($tableimageuser->image)) {
                        Storage::disk('public')->delete($tableimageuser->image);
                    }
                }

                    User::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(__('Dashboard/messages.delete'));
                return redirect()->route('Users.softdeleteusers');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('Users.softdeleteusers');
            }
        }
        //! Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();

                    $users = User::withTrashed()
                    ->whereIn('id', $delete_select_id)
                    ->get();

                    foreach ($users as $user) {

                        // حذف الصورة إذا كانت موجودة
                        if (!empty($user->image) && Storage::disk('public')->exists($user->image)) {
                            Storage::disk('public')->delete($user->image);
                        }

                        // حذف المستخدم نهائياً
                        $user->forceDelete();
                    }

                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Users.softdeleteusers');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Users.softdeleteusers');
            }
        }
        //! Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                $tableimageuser = User::where('id',$delete_select_id)->first();
                if(!empty($tableimageuser->image)){
                    if ($tableimageuser->image && Storage::disk('public')->exists($tableimageuser->image)) {
                        Storage::disk('public')->delete($tableimageuser->image);
                    }
                }
                DB::beginTransaction();
                    User::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('users.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('users.index');
            }
        }
    }

    //* Restore One User
    public function restoreusers($id){
        try{
            DB::beginTransaction();
                User::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Users.softdeleteusers');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Users.softdeleteusers');
        }
    }

    //* Restore All Users
    public function restoreallusers()
    {
        try{
            DB::beginTransaction();
                User::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Users.softdeleteusers');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Users.softdeleteusers');
        }
    }

    //* Restore All Select Users
    public function restoreallselectusers(Request $request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    User::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Users.softdeleteusers');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Users.softdeleteusers');
        }
    }

    public function softusers(Request $request)
    {
        $users = User::onlyTrashed()->latest()->whereNot('id', '1')->whereNot('id', Auth::user()->id)->paginate(5);
        return view('Dashboard_UMC.users.users.softdeletesusers',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    //* Delete All Users (Except the user who is logged in) & (Except for the Super Admin)
    public function deleteallusers(){
        DB::table('users')->whereNull('deleted_at')->whereNot('id', '1')->whereNot('id', Auth::user()->id)->delete();
        return redirect()->route('users.index');
    }

    //* Delete All Users Sofdelete (Except the user who is logged in) & (Except for the Super Admin)
    public function deletealluserssoftdelete(){
        DB::table('users')->whereNotNull('deleted_at')->where('id', '!=', 1)->where('id', '!=', Auth::id())->delete();

        $users = User::onlyTrashed()
            ->where('id', '!=', 1)
            ->where('id', '!=', Auth::id())
            ->get();

        foreach ($users as $user) {
            // حذف الصورة إذا كانت موجودة
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
        }
        return redirect()->route('Users.softdeleteusers');
    }
}
