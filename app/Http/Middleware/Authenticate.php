<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $guard = $request->expectsJson() ? null : $this->auth->getDefaultDriver();

        if ($guard === 'customer') {
            return route('customerLogin');
        } elseif ($guard === 'user') {
            return route('adminLogin');
        }

        return null;
    }
}
