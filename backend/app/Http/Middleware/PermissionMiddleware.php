<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non authentifié.',
            ], 401);
        }

        if (!$user->hasPermission($permission)) {
            return response()->json([
                'message' => 'Vous n\'avez pas la permission nécessaire.',
            ], 403);
        }

        return $next($request);
    }
}