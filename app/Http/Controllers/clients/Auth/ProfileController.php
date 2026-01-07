<?php

namespace App\Http\Controllers\clients\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Client;
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
        return view('Dashboard_UMC.clients.profile.edit', [
            'client' => Auth::guard('clients')->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateprofile(ProfileUpdateRequest $request): RedirectResponse
    {
        try{
            $user_id = Auth::guard('clients')->user()->id;
            $user = Client::findOrFail($user_id);
                DB::beginTransaction();
                    $user->update([
                        'name' =>  $request->name,
                        'phone' => $request->phone,
                    ]);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('profileclient.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profileclient.edit');
        }

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
            $client = Auth::guard('clients')->user();

            // حذف حساب العميل
            $client->delete();

            // تسجيل الخروج
            Auth::guard('clients')->logout();

            // تنظيف الجلسة
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/clients');

    }
}
