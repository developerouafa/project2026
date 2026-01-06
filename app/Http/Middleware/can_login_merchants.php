<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use App\Models\merchants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class can_login_merchants
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('merchants')->check()){
            $id = Auth::guard('merchants')->user()->id;
            $user = Merchant::findorFail($id);
            $user->update([
                'can_login' => 1,
            ]);
        }
        return $next($request);
    }
}
