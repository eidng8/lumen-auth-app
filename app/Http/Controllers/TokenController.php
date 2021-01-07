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
}
