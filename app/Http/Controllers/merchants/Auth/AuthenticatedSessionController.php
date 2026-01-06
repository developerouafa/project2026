<?php

namespace App\Http\Controllers\merchants\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginRequestmerchante;
use App\Models\Merchant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Dashboard_UMC.merchants.auth.signin');

    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequestmerchante $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $request->authenticate();
        $request->session()->regenerate();
        if(Auth::guard('merchants')->user()->account_state == "active"){
            return redirect()->intended('/merchants');
        }
        else{
            $id = Auth::guard('merchants')->id();
            $merchant = Merchant::findorFail($id);
            $merchant->update([
                'can_login' => 0,
            ]);
            Auth::guard('merchants')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/merchants');
        }


        // if ($request->authenticate()) {
        //     $request->session()->regenerate();
        //     if(Auth::guard('merchants')->user()->account_state == "active"){
        //         return redirect()->intended('/merchants');
        //     }
        //     else{
        //         $id = Auth::guard('merchants')->id();
        //         $merchant = Merchant::findorFail($id);
        //         $merchant->update([
        //             'can_login' => 0,
        //         ]);
        //         Auth::guard('merchants')->logout();
        //         $request->session()->invalidate();
        //         $request->session()->regenerateToken();
        //         return redirect('/');
        //     }
        // }
        // return redirect()->back()->withErrors(['name' => (trans('Dashboard/messages.error'))]);


    }
// public function store(Request $request)
// {
//     $request->authenticate();
//     $request->session()->regenerate();

//     $merchant = Auth::guard('merchants')->user();

//     if ($merchant->account_state === 'active') {
//         return redirect()->intended('/merchants');
//     }

//     // الحساب غير مفعل
//     Auth::guard('merchants')->logout();
//     $request->session()->invalidate();
//     $request->session()->regenerateToken();

//     return redirect('/merchants/login')
//         ->withErrors([
//             'email' => 'حسابك غير مفعّل حالياً.',
//         ]);
// }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $id = Auth::guard('merchants')->id();
        $merchant = Merchant::findorFail($id);
        $merchant->update([
            'can_login' => 0,
        ]);

        Auth::guard('merchants')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/merchants');

    }
}
