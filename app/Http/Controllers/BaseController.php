<?php


namespace App\Http\Controllers;


abstract class BaseController extends Controller
{

    protected function failedResponse($message = 'Bad Request', int $status = 400)
    {
        return response()->json([
            'message' => $message
        ], $status);
    }


    protected function successfulResponse(int $status = 200, $data = [], string $message = 'successful')
    {

        $response = [
            'message' => $message,
            'data' => (object)$data
        ];


        return response()->json($response, $status);
    }

}
