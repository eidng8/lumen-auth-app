<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Factory;

/**
 * Generating responses with JWT tokens.
 */
trait TokenResponse
{
    /**
     * Generate a JSON response with the given JWT token.
     * There are two extra fields placed side by side with the token.
     *
     * + `token_type` is a constant with value `bearer`;
     * + `expires_in` is the TTL in seconds.
     *
     * example:
     * ```json
     * {
     *   "token":      "...",
     *   "token_type:  "bearer",
     *   "expires_in": 3600
     * }
     * ```
     *
     * More on the JWT token:
     * + The `iss` claim is the URL of this end point. Currently there are only
     *   two end points that will generate tokens: `login` and `refresh`. If
     *   given the domain `some.domain.com` and using HTTPS protocol,
     *   only two possible `iss` would be:
     *     - https://some.domain.com/login
     *     - https://some.domain.com/refresh
     * + The `sub` claim holds user ID (most likely the database primary key).
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        /* @var Factory $factory */
        /* @noinspection PhpParamsInspection */
        $factory = auth()->factory();
        $ttl = $factory->getTTL() * 60;  // converts minute to seconds

        return response()->json(
            [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $ttl,
            ],
        );
    }
}
