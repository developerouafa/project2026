<?php

namespace App\Http\Controllers\users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    //* Display the user's profile form
    public function edit(Request $request): View
    {
        return view('Dashboard_UMC.users.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    //* function Update Information User
    public function updateprofile(ProfileUpdateRequest $request)
    {
        try{
            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);
                DB::beginTransaction();
                    $user->update([
                        'name' =>  $request->name,
                        'phone' => $request->phone,
                    ]);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('profile.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profile.edit');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
