<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, Request $req)
    {
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (! $req->user()->hasAnyRole($roles)) {
            return response()->json([
                'message' => 'permission denied!',
                'role' => explode('|', $role)
            ]);
        }

        return $next($request);
    }
}
