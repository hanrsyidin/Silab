<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, $role): Response
    // {
    //     if(!Auth::check()){
    //         return redirect()->route('login');
    //     }

    //     $authUserRole = Auth::user()->role;

    //     switch($role){
    //         case 'admin':
    //             if($authUserRole == 0){
    //                 return $next($request);
    //             }
    //             break;
    //         case 'customer':
    //             if($authUserRole == 1){
    //                 return $next($request);
    //             }
    //             break;
    //     }

    //     switch($role){
    //         case 0:
    //             return redirect()->route('admin');
    //         case 1:
    //             return redirect()->route('dashboard');
    //     }

    //     return redirect()->route('login');
    // }

    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $authUserRole = Auth::user()->role;
    
        // Asumsikan parameter role dikirim sebagai string: 'admin' atau 'customer'
        if ($role === 'admin' && $authUserRole == 0) {
            return $next($request);
        }
    
        if ($role === 'customer' && $authUserRole == 1) {
            return $next($request);
        }
    
        // Jika role tidak sesuai, redirect sesuai logika:
        // Misal, admin diarahkan ke route 'admin', customer ke 'dashboard'
        if ($authUserRole == 0) {
            return redirect()->route('admin');
        }
    
        if ($authUserRole == 1) {
            return redirect()->route('dashboard');
        }
    
        return redirect()->route('login');
    }    
}
