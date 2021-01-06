<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 */

namespace App\Http\Controllers;


use App\Traits\TokenResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    use TokenResponse;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function refresh(Request $request): JsonResponse
    {
        /* @noinspection PhpParamsInspection */
        return $this->respondWithToken(auth()->refresh(true, true));
    }

}
