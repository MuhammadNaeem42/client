<?php

namespace App\Http\Controllers;

use App\Traits\ResponseUtil;
use Response;



class AppBaseController extends Controller
{

    use ResponseUtil;

    public function sendResponse($result, $message): \Illuminate\Http\JsonResponse
    {
        return Response::json($this->makeResponse($message, $result));
    }

    public function sendError($error, $code = 200): \Illuminate\Http\JsonResponse
    {
        return Response::json($this->makeError($error), $code);
    }

    public function sendSuccess($message): \Illuminate\Http\JsonResponse
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
