<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class can_login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تجاهل Livewire و Ajax و API
        if (
            $request->is('livewire/*') ||
            $request->is('_livewire/*') ||
            $request->expectsJson()
        ) {
            return $next($request);
        }
        if(Auth::guard('web')->check()){

                $user = Auth::guard('web')->user();
                // حدّث فقط إذا مازال 0
                if ($user->can_login == 0) {
                    $user->update([
                        'can_login' => 1,
                    ]);
                }
            // $id = Auth::user()->id;
            // $user = User::findorFail($id);
            // $user->update([
            //     'can_login' => 1,
            // ]);
        }
        return $next($request);
    }
}
