<?php

namespace App\Http\Middleware;

use Closure;

class ManageUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth_user = $request->user();

        if ($auth_user && $auth_user->can_manage_users) {
            return $next($request);
        }

        return redirect('/');
    }
}
