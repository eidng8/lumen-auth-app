<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

namespace App\Http\Controllers;

use App\Jobs\PasswordReset;
use App\Models\User;
use App\Traits\TokenResponse;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Authentication controller.
 */
class AuthController extends Controller
{
    use TokenResponse;

    /**
     * Store a new user.
     *
     * @param  Request  $request
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
                'name' => 'required|string|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|confirmed',
            ]
        );

        try {
            $user = $this->createUser($request);

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
                    'error' => $e->getMessage(),
                ],
                409
            );
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
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
                'email' => 'required|email',
                'password' => 'required|string',
            ]
        );

        $credentials = $request->only(['email', 'password']);

        /* @var string|bool $token */
        // JWTGuard::attempt() by default, will return the token on success.
        $token = auth()->attempt($credentials);
        if ($token) {
            return $this->respondWithToken($token);
        }

        return response()->json(
            ['message' => __('The given credentials cannot be found.')],
            401
        );
    }

    /**
     * Start the password reset process, this is the first step of the process.
     * Here a simple job is pushed to the queue without any further process.
     *
     * https://laravel.com/docs/8.x/passwords
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function passwordReset(Request $request): JsonResponse
    {
        // Simply verify that the given email exists in the database.
        // This is a bare-bone demonstration. Extra measures must be taken in
        // real world application to mitigate security threats.
        $this->validate($request, ['email' => 'required|email|exists:users']);
        dispatch(new PasswordReset($request->input('email')));

        return response()->json(
            [
                'message' => __(
                    'Password reset email has been sent to your email.'
                ),
            ]
        );
    }

    /**
     * Add the requested user credentials to database.
     *
     * @param  Request  $request
     *
     * @return User
     */
    private function createUser(Request $request): User
    {
        $user = new User($request->only(['name', 'email']));
        $user->password = app('hash')->make($request->input('password'));
        $user->save();

        return $user;
    }
}
