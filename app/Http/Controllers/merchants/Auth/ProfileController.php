<?php

namespace App\Http\Controllers\merchants\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Merchant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('Dashboard_UMC.merchants.profile.edit', [
            'merchant' => Auth::guard('merchants')->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateprofile(ProfileUpdateRequest $request): RedirectResponse
    {
        try{
            $user_id = Auth::guard('merchants')->user()->id;
            $user = Merchant::findOrFail($user_id);
                DB::beginTransaction();
                    $user->update([
                        'name' =>  $request->name,
                        'phone' => $request->phone,
                    ]);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('profilemerchant.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profilemerchant.edit');
        }

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
            $merchant = Auth::guard('merchants')->user();

            // حذف حساب التاجر
            $merchant->delete();

            // تسجيل الخروج
            Auth::guard('merchants')->logout();

            // تنظيف الجلسة
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/merchants');

    }
}
