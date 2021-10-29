<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Role::find(Auth::user()->role)->name != 'admin'){
            return response()->json([
                'status' => 'error',
                'description' => 'you have not a permission for this api'
            ],401);
        }

        return $next($request);
    }
}
