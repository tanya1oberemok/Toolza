<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * @param $result
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
        ];

        return response()->json($response, 200);
    }

    /**
     * @param $error
     * @param $errorMessages
     * @param $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
