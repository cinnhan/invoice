<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * get the currently authenticated account
     * @return Authenticatable|object|null
     */
    public function getAccount()
    {
        return auth()->user();
    }

    /**
     * response Success
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccess($data = [], $message = '', $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * response Error
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function responseError($message, $data = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

}
