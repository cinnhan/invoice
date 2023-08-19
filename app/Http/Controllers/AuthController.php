<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * create a new NewsAuthController instance
     */
    public function __construct()
    {

    }

    /**
     * get a JWT via given credentials
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return $this->responseError('', $validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return $this->responseError('Unauthorized', [], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * log the account out (Invalidate the token).
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->responseSuccess('User successfully signed out');
    }

    /**
     * get the token array structure.
     * @param $token
     * @return JsonResponse
     */
    protected function createNewToken($token)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'account' => $this->getAccount(),
        ];

        return $this->responseSuccess($data);
    }

}
