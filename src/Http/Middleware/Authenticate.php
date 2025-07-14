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
        if ($this->auth->guard('canvas')->check()) {
            $this->auth->shouldUse('canvas');
        } else {
            throw new AuthenticationException(
                'Unauthenticated.', ['canvas'], route('canvas.login')
            );
        }

        return $next($request);
    }
}
