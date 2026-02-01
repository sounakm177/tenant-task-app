<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsResolved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // User must be authenticated
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // Admin may access without tenant (optional but realistic)
        if ($user->isAdmin()) {
            return $next($request);
        }

        // User must belong to a company (tenant)
        if (!$user->company_id || !$user->company) {
            abort(403, 'User does not belong to any company.');
        }

        // Company must be active
        if (!$user->company->status) {
            abort(403, 'Company is inactive.');
        }

        /**
         * Share current tenant globally
         * (useful for services, policies, repositories)
         */
        app()->instance('currentCompany', $user->company);

        return $next($request);
    }

}