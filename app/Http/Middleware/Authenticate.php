<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTGuard;

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

    private function checkIssuer(JWTGuard $guard): bool
    {
        $accepted = config('jwt.accepted_issuers');
        // allow all issuers if the configuration is not set
        if (count($accepted) == 0) {
            return true;
        }
        return in_array($guard->getPayload()->get('iss'), $accepted);
    }

    private function checkTokenType(Request $request): bool
    {
        $header = $request->headers->get('Authorization');
        if ($header) {
            $parts = explode(' ', $header);
            if (count($parts) == 2) {
                return 'bearer' == $parts[0];
            }
        }
        return false;
    }
}
