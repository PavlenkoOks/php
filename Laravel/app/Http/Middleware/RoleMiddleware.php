<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$rolesAndRedirectRoute)
    {
        $actionName = Route::currentRouteAction();

        if ($actionName && preg_match('/@(?:index|show)$/', $actionName)) {
            return $next($request);
        }

        $token = session('token');
        $user = null;
        $allowedRoles = [];

        if (!empty($rolesAndRedirectRoute)) {
            $lastElement = end($rolesAndRedirectRoute);
            if (is_string($lastElement) && Route::has($lastElement)) {
                $redirectRoute = array_pop($rolesAndRedirectRoute);
            } else {
                $redirectRoute = 'logout';
            }

            $allowedRoles = $rolesAndRedirectRoute;
        }

        if ($token) {
            try {
                $user = JWTAuth::setToken($token)->authenticate();
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            }
        }

        if (!$user || !in_array($user->role ?? null, $allowedRoles)) {
            return redirect()->route($redirectRoute)->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
