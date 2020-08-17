<?php

namespace App\Http\Controllers;

use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message = null)
    {
        $res = [
            'success' => true,
            'message' => $message,
            'current' => \Carbon\Carbon::now()->toDateTimeString(),
            'data' => $result,
        ];

        return response()->json($res);
    }

    public function sendError($error, $code = 404)
    {
        $res = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($res, $code);
    }

    public function sendMessageSuccess($result, $message)
    {
        $res = [
            'success' => true,
            'message' => $message,
            'current' => \Carbon\Carbon::now()->toDateTimeString(),
            'data' => $result
        ];
        return response()->json($res);
    }

    public function sendMessageFail($message, $code = 400)
    {
        $res = [
            'success' => false,
            'message' => $message
        ];
        return response()->json($res, $code);
    }
}
