<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        abort_unless($user && $user->hasAnyRole([
            'super_admin', 'owner', 'admin_operasional', 'customer_service',
            'driver', 'tour_leader', 'keuangan', 'marketing',
        ]), 403, 'Anda tidak memiliki akses ke halaman ini.');

        return $next($request);
    }
}