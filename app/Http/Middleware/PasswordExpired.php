<?php

namespace App\Http\Middleware;

use Closure;

class PasswordExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $password_changed_at = auth()->guard('customer')->user()->password_changed_at;

        if (!$password_changed_at) {
            return redirect()->route('customer.password-expired.create');
        }

        return $next($request);
    }
}
