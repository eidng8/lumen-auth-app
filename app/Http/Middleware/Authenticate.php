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
     * @param Auth $auth
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
     * @param Request     $request
     * @param Closure     $next
     * @param string|null $guard
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
        if (!$jwtGuard->guest()
            && $this->checkIssuer($jwtGuard)
            && $this->checkTokenType($request)) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }

    /**
     * Check whether the issuer of requested token were accepted.
     *
     * @param  JWTGuard  $guard
     *
     * @return bool
     */
    private function checkIssuer(JWTGuard $guard): bool
    {
        // If `.env` sets `JWT_ACCEPTED_ISSUERS=` (nothing follows the equal
        // sign), the `config()` call below returns differently on different
        // OS. It returns an empty array on Windows, even in WSL Ubuntu.
        // However it returns an array with one empty string (`['']`). We have
        // to explicitly deal with that.
        $accepted = array_filter(config('jwt.accepted_issuers'));
        // allow all issuers if the configuration is not set
        if (count($accepted) == 0) {
            return true;
        }

        return in_array($guard->getPayload()->get('iss'), $accepted);
    }

    /**
     * Check whether the token type were correct.
     *
     * @param  Request  $request
     *
     * @return bool
     */
    private function checkTokenType(Request $request): bool
    {
        $header = $request->headers->get('authorization');
        if ($header) {
            $parts = explode(' ', $header);
            if (count($parts) == 2) {
                return 'bearer' == $parts[0];
            }
        }

        return false;
    }
}
