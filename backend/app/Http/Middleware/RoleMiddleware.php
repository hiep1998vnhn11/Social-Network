<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle($request, Closure $next, $role)
    {
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (! auth()->user()->hasAnyRole($roles)) {
            return response()->json([
                'message' => 'permission denied!',
                'role' => explode('|', $role)
            ]);
        }

        return $next($request);
    }
}
