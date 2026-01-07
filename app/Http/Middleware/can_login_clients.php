<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class can_login_clients
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('clients')->check()){
            $id = Auth::guard('clients')->user()->id;
            $user = Client::findorFail($id);
            $user->update([
                'can_login' => 1,
            ]);
        }
        return $next($request);
    }
}
