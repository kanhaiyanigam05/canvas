
<?php

namespace Kanhaiyanigam05\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Authenticate
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        // Allow access to login page without authentication check
        if ($request->is('canvas/auth/login')) {
            // If already authenticated, redirect to canvas dashboard
            if ($this->auth->guard('canvas')->check()) {
                return redirect(config('canvas.path'));
            }
            return $next($request);
        }

        // For all other routes, check authentication
        if (!$this->auth->guard('canvas')->check()) {
            throw new AuthenticationException(
//                'Unauthenticated.', ['canvas'], route('canvas.login')
            );
        }

        $this->auth->shouldUse('canvas');
        return $next($request);
    }
}
