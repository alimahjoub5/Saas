<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComplianceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->compliance_mode && $request->has('source_type')) {
            $allowed = ['email', 'rss', 'api', 'manual', 'csv'];

            if (! in_array($request->input('source_type'), $allowed, true)) {
                abort(403, 'Compliance mode blocks non-approved sources.');
            }
        }

        return $next($request);
    }
}
