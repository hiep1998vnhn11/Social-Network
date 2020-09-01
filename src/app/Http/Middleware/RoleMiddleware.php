<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Consts;

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
        $code = Consts::UNAUTHORIZED_CODE;
        if (!auth('api')->user()){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized!',
                'error_code' => $code
            ],$code);
        }
        if (! auth('api')->user()->hasAnyRole($roles)) {
            return response()->json([
                'success' => false,
                'message' => 'permission denied!',
                'current' => \Carbon\Carbon::now()->toDateTimeString(),
                'role' => explode('|', $role)
            ]);
        }

        return $next($request);
    }
}
