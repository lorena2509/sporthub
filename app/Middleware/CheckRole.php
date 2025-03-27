<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        if (!$role || (auth()->check() && auth()->user()->role->name === $role)) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }
}
