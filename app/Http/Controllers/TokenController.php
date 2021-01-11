<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace App\Http\Controllers;

use App\Traits\TokenResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

/**
 * JWT token related services.
 */
class TokenController extends Controller
{
    use TokenResponse;

    /**
     * The middleware defined on the controller.
     *
     * @var array
     */
    protected $middleware = ['auth' => []];

    /**
     * Refreshes a JWT token of current request.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        /* @noinspection PhpParamsInspection */
        return $this->respondWithToken(auth()->refresh(true, true));
    }

    /**
     * Logout the current user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => __('See you soon.')]);
    }

    /**
     * Validates the token and returns its TTL if it's valid.
     *
     * This is just a scaffold, feel free to implement whatever suitable.
     *
     * @return JsonResponse
     */
    public function verify(): JsonResponse
    {
        /* @noinspection PhpParamsInspection PhpUndefinedMethodInspection */
        return $this->respond(['ttl' => auth()->factory()->getTTL() * 60]);
    }

    /**
     * Returns the current server time in W3C format.
     *
     * This is just a scaffold, feel free to implement whatever suitable.
     *
     * @return JsonResponse
     */
    public function heartbeat(): JsonResponse
    {
        return $this->respond(['time' => Carbon::now()->toW3cString()]);
    }
}
