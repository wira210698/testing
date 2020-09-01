<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role_ids)
    {
        if (in_array($request->user()->role_id, $role_ids)) {
            return $next($request);
        }
        return redirect('/ibu');
    }
}
