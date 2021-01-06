<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 */

namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait TokenResponse
{

    /**
     * @param $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        /* @noinspection PhpParamsInspection PhpUndefinedMethodInspection */
        $ttl = auth()->factory()->getTTL() * 60;  // converts minute to seconds
        return response()->json(
            [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $ttl,
            ],
        );
    }
}
