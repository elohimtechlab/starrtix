<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CheckFrontendMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $setting = Setting::first();
        
        // Check if frontend maintenance is enabled
        if ($setting && $setting->frontend_maintenance == 1) {
            // Allow admin users to access the site
            if (Auth::check() && Auth::user()->hasRole('admin')) {
                return $next($request);
            }
            
            // Allow access to admin routes
            if ($request->is('admin/*') || $request->is('login') || $request->is('logout')) {
                return $next($request);
            }
            
            // Show maintenance page for frontend users
            return response()->view('frontend.maintenance', [
                'setting' => $setting
            ], 503);
        }
        
        return $next($request);
    }
}
