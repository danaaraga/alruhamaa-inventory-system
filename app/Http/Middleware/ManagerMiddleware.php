<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || (!Auth::user()->isManager() && !Auth::user()->isAdmin())) {
            abort(403, 'Akses ditolak. Hanya Manager dan Admin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}