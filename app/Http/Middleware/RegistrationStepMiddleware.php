<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationStepMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->hasRole(['indivisual-member', 'family-leader', 'group-leader'])) {

            // Step 1: Check payment status
            // dd($user);
            if ($user->payment_status !== 'paid') {
                // Allow access to registration form + store route only
                if (!$request->routeIs(['admin.payments.registration_index', 'admin.payments.registration_store'])) {
                    return redirect()->route('admin.payments.registration_index');
                }
            } else {
                // Step 2: Payment is done, check if organization exists
                if (method_exists($user, 'organizations')) {
                    $orgCount = $user->organizations()->count();

                    if ($orgCount === 0) {
                        if (!$request->routeIs(['admin.payments.organization_index', 'admin.payments.organization_store'])) {
                            return redirect()->route('admin.payments.organization_index');
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
