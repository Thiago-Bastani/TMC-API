<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNoAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminExists = User::where('is_admin', true)->exists();

        if (!$adminExists && !$request->is('setup')) {
            return redirect('/setup');
        }

        if ($adminExists && $request->is('setup')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
