<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTGuard;

/**
 * Authentication middleware. Please note that the token *must* be provided in
 * the `authorization` HTTP header.
 */
class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var Auth
     */
    protected Auth $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Auth  $auth
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     *
     * @return mixed
     */
    public function handle(
        Request $request,
        Closure $next,
        $guard = null
    ): mixed {
        /* @var JWTGuard $jwtGuard */
        $jwtGuard = $this->auth->guard($guard);
        if ($jwtGuard->guest()) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
