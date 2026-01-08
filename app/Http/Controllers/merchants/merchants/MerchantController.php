<?php

namespace App\Http\Controllers\merchants\merchants;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\HttpCache\Store;

class MerchantController extends Controller
{
    //* Page Show merchants (Except the merchant who is logged in) & (Except for the Super Admin)
    public function index(Request $request)
    {
        // $merchants = Merchant::orderBy('id','DESC')->where('id', '!=', '1')->where('id', '!=', Auth::guard('merchants')->id())->paginate(5);
        $merchants = Merchant::orderBy('id','DESC')->paginate(5);
        return view('Dashboard_UMC.merchants.merchants.show_merchants',compact('merchants'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    //* Create New merchant
    public function create()
    {
        $roles = Role::where('guard_name', 'merchants')->pluck('name', 'name')->all();
        return view('Dashboard_UMC.merchants.merchants.Add_merchant',compact('roles'));
    }

    //* Store merchant
    public function store(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();
                $merchant = Merchant::create([
                    'name' => ['en' => $request->nameen, 'ar' => $request->namear],
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                $merchant->assignRole($request->input('roles_name'));
            DB::commit();
            toastr()->success(__('Dashboard/messages.add'));
            return redirect()->route('merchant.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('merchant.create');
        }
    }

    //* Show One merchant
    public function show($id)
    {
        $merchant = Merchant::find($id);
        return view('Dashboard_UMC.merchants.merchants.show',compact('merchant'));
    }

    //* Page Edit merchant
    public function edit($id)
    {
        $merchant = Merchant::find($id);
        $roles = Role::where('guard_name', 'merchants')->pluck('name','name')->all();
        $merchantRole = $merchant->roles->pluck('name','name')->all();
        return view('Dashboard_UMC.merchants.merchants.edit',compact('merchant','roles','merchantRole'));
    }

    //* Update merchant
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'email' => 'required|email|unique:merchants,email,'.$id,
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

                $merchant = Merchant::find($id);
                $password = $merchant->password;

                    if(!empty($input['password'])){
                        $merchant->update([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                        ]);
                    }else{
                        $merchant->update([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => $password,
                        ]);
                    }

                DB::table('model_has_roles')->where('model_id',$id)->delete();
                $merchant->assignRole($request->input('roles'));

            DB::commit();
            toastr()->success(__('Dashboard/messages.edit'));
            return redirect()->route('merchant.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('merchant.update');
        }
    }

    public function destroy(Request $request)
    {
        //! Delete One Request
        if($request->page_id==1){
            try{
                $id = $request->merchant_id;
                $tableimagemerchant = Merchant::where('id',$id)->first();
                if(!empty($tableimagemerchant->image)){
                    if ($tableimagemerchant->image && Storage::disk('public')->exists($tableimagemerchant->image)) {
                        Storage::disk('public')->delete($tableimagemerchant->image);
                    }
                }
                DB::beginTransaction();
                    Merchant::find($id)->delete();
                DB::commit();
                toastr()->success(__('Dashboard/messages.delete'));
                return redirect()->route('merchant.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('merchant.index');
            }
        }
        //! Delete One SoftDelete
        if($request->page_id==3){
            try{
                $id = $request->merchant_id;
                $tableimagemerchant = Merchant::where('id',$id)->first();
                DB::beginTransaction();
                if(!empty($tableimagemerchant->image)){
                    if ($tableimagemerchant->image && Storage::disk('public')->exists($tableimagemerchant->image)) {
                        Storage::disk('public')->delete($tableimagemerchant->image);
                    }
                }

                    Merchant::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(__('Dashboard/messages.delete'));
                return redirect()->route('merchant.softdeletemerchants');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('merchant.softdeletemerchants');
            }
        }
        //! Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();

                    $merchants = Merchant::withTrashed()
                    ->whereIn('id', $delete_select_id)
                    ->get();

                    foreach ($merchants as $merchant) {
                        // حذف الصورة إذا كانت موجودة
                        if (!empty($merchant->image) && Storage::disk('public')->exists($merchant->image)) {
                            Storage::disk('public')->delete($merchant->image);
                        }

                        // حذف المستخدم نهائياً
                        $merchant->forceDelete();
                    }

                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('merchant.softdeletemerchants');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('merchant.softdeletemerchants');
            }
        }
        //! Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                $tableimagemerchant = Merchant::where('id',$delete_select_id)->first();
                if(!empty($tableimagemerchant->image)){
                    if ($tableimagemerchant->image && Storage::disk('public')->exists($tableimagemerchant->image)) {
                        Storage::disk('public')->delete($tableimagemerchant->image);
                    }
                }
                DB::beginTransaction();
                    Merchant::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('merchant.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('merchant.index');
            }
        }
    }

    //* Restore One merchant
    public function restoremerchants($id){
        try{
            DB::beginTransaction();
                Merchant::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('merchant.softdeletemerchants');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('merchant.softdeletemerchants');
        }
    }

    //* Restore All merchants
    public function restoreallmerchants()
    {
        try{
            DB::beginTransaction();
                Merchant::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('merchant.softdeletemerchants');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('merchant.softdeletemerchants');
        }
    }

    //* Restore All Select merchants
    public function restoreallselectmerchants(Request $request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    Merchant::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('merchant.softdeletemerchants');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('merchant.softdeletemerchants');
        }
    }

    //* Page Show SoftDelete merchants (Except the Merchant who is logged in) & (Except for the Super Admin)
    public function softmerchants(Request $request)
    {
        $merchants = Merchant::onlyTrashed()->latest()->where('id', '!=', '1')->where('id', '!=', Auth::guard('merchants')->id())->paginate(5);
        return view('Dashboard_UMC.merchants.merchants.softdeletesmerchants',compact('merchants'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    //* Delete All merchants (Except the Merchant who is logged in) & (Except for the Super Admin)
    public function deleteallmerchants(){
        DB::table('merchants')->whereNull('deleted_at')->where('id', '!=', '1')->where('id', '!=', Auth::guard('merchants')->id())->delete();
        return redirect()->route('merchant.index');
    }

    //* Delete All merchants Sofdelete (Except the merchant who is logged in) & (Except for the Super Admin)
    public function deleteallmerchantssoftdelete(){
        DB::table('merchants')->whereNotNull('deleted_at')->where('id', '!=', 1)->where('id', '!=', Auth::guard('merchant')->id())->delete();

        $merchants = Merchant::onlyTrashed()
            ->where('id', '!=', 1)
            ->where('id', '!=', Auth::guard('merchant')->id())
            ->get();

        foreach ($merchants as $merchant) {
            // حذف الصورة إذا كانت موجودة
            if ($merchant->image && Storage::disk('public')->exists($merchant->image)) {
                Storage::disk('public')->delete($merchant->image);
            }
        }
        return redirect()->route('merchant.softdeletemerchants');
    }
}
