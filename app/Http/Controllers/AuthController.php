<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param Request $request
     *
     * @return Response
     * @throws ValidationException
     */
    public function register(Request $request): Response
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
            $user = new User(
                [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                ]
            );
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            // return successful response
            return response()->json(
                [
                    'user' => $user,
                    'message' => __('User has been successfully created.'),
                ]
            );
        } catch (Exception $e) {
            // return error message
            return response()->json(
                [
                    'message' => __('User Registration Failed!'),
                    'error' => $e,
                ],
                409
            );
        }
    }
}
