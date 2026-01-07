<?php

namespace App\Http\Controllers\clients\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequestclient;
use App\Models\Client;
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
        return view('Dashboard_UMC.clients.auth.signin');

    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequestclient $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $request->authenticate();
        $request->session()->regenerate();
        if(Auth::guard('clients')->user()->account_state == "active"){
            return redirect()->intended('/clients');
        }
        else{
            $id = Auth::guard('clients')->id();
            $client = Client::findorFail($id);
            $client->update([
                'can_login' => 0,
            ]);
            Auth::guard('clients')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/clients');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $id = Auth::guard('clients')->id();
        $client = Client::findorFail($id);
        $client->update([
            'can_login' => 0,
        ]);
        Auth::guard('clients')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended('/clients');
    }
}
