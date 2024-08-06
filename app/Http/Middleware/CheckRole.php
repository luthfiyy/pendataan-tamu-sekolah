<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



// class Admin
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         if (Auth::user()->role != 'admin')
//         {
//             return redirect('/');
//         }

//         return $next($request);
//     }
// }

class CheckRole
{
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($role && $user->role !== $role) {
            // Redirect ke halaman yang sesuai berdasarkan peran pengguna
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'FO':
                    return redirect()->route('FO.dashboard');
                case 'pegawai':
                    return redirect()->route('pegawai.dashboard');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
