<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (!Auth::check()) {
            return Response()->json([
                'message' => 'Access denied!'
            ], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        if (!$user->permissions()->whereIn('name', $permissions)->exists()) {
            return Response()->json([
                'message' => 'Access denied!'
            ], HttpResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
