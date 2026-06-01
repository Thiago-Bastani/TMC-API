<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->status !== 'approved') {
            return response()->json(['message' => 'Account not approved.'], 403);
        }

        return $next($request);
    }
}
