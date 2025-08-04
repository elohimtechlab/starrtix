<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = 'appuser')
    {
        if (!Auth::guard($guard)->check()) {
            // Store the intended URL in session for redirect after login
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            
            // Store the current URL as intended URL for post-login redirect
            session(['url.intended' => $request->url()]);
            
            return redirect('user/login');
        }
        
        return $next($request);
    }
}
