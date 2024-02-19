<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function respond($data, $code)
    {
        return response()->json($data, $code);
    }

    public function destroyed($message = 'Deleted Successfully', $code = 200)
    {
        return response()->json($message, $code);
    }

    public function respondWithSucsses($data, $message = 'Success', $code = 200)
    {
        return $this->respond([
            'success' => [
                'message' => $message,
                'data' => $data
            ]
        ], $code);
    }

    public function respondWithError($message, $code)
    {
        return $this->respond([
            'error' => [
                'message' => $message
            ]
        ], $code);
    }
}
