<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectAdminRootToProfile
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin') || $request->is('admin/')) {
            return redirect('/admin/perfil');
        }

        return $next($request);
    }
}
