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
        //jika akun yang login sesuai dengan role
        //maka silahkan akses
        //jika tidak sesuai akan diarahkan ke home

        $roles = array_slice(func_get_args(), 2);

        foreach ($roles as $role) {
            $user = Auth::user()->role;
            if ($user == $role) {
                return $next($request);
            }
        }

        return abort(403);

        //return redirect('/');
        //return $next($request);
    }
}
