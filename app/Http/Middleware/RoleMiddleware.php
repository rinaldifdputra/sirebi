<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
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
        $roles = array_slice(func_get_args(), 2);

        // Pastikan user sudah login
        if (Auth::check()) {
            $user = Auth::user();

            foreach ($roles as $role) {
                if ($user->role == $role) {
                    return $next($request);
                }
            }

            // Jika user tidak memiliki role yang diizinkan, beri response error 403
            return abort(403, 'Unauthorized action.');
        }

        // Jika user belum login, arahkan ke halaman login
        return redirect('/login');
    }
}
