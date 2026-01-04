<?php

namespace App\Http\Controllers\users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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
        return view('Dashboard_UMC.users.auth.signin');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));

        $request->authenticate();
        $request->session()->regenerate();
        if(Auth::user()->account_state == "1"){
            return redirect()->intended('/dashboard');
        }
        else{
            $id = Auth::user()->id;
            $user = User::findorFail($id);
            $user->update([
                'can_login' => 0,
            ]);
            Auth::guard('users')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $id = Auth::user()->id;
        $user = User::findorFail($id);
        $user->update([
            'can_login' => 0,
        ]);

        Auth::guard('users')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
