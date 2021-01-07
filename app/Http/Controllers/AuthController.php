<?php
/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\TokenResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


/**
 * Authentication controller
 */
class AuthController extends Controller
{
    use TokenResponse;

    /**
     * Store a new user.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        // validate incoming request
        $this->validate(
            $request,
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|confirmed',
            ]
        );

        try {
            $user = new User($request->only(['name', 'email']));
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            // return successful response, HTTP 201 means "created".
            // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/201
            return response()->json(
                [
                    'user' => $user,
                    'message' => __('User has been successfully created.'),
                ],
                201
            );
        } catch (Exception $e) {
            // return error message, HTTP 409 means "conflict".
            // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/409
            return response()->json(
                [
                    'message' => __('User Registration Failed!'),
                    'error' => $e,
                ],
                409
            );
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        // validate incoming request
        $this->validate(
            $request,
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ]
        );

        $credentials = $request->only(['email', 'password']);

        /* @var string|bool $token */
        // JWTGuard::attempt() by default, will return the token on success.
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(
                ['message' => __('The given credentials cannot be found.')],
                401
            );
        }

        return $this->respondWithToken($token);
    }
}
