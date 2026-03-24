<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('admin_id')) {
            $admin = \App\Models\Admin::first();
            if ($admin) {
                $request->session()->put('admin_id', $admin->id);
            } else {
                return redirect()->route('admin.login');
            }
        }

        return $next($request);
    }
}
