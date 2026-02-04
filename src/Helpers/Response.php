<?php
namespace App\Helpers;

class Response
{
    public static function success($data, $message, $httpCode = 200)
    {
        http_response_code($httpCode);
        echo json_encode([
            "success"=> true,
            "data" => $data,
            "message"=> $message
        ]);
        exit;
    }

    public static function error($message, $errorCode, $httpCode = 400)
    {
        http_response_code($httpCode);
        echo json_encode([
            "success"=> false,
            "error" => [
                "code"=> $errorCode,
                "message"=> $message
            ]
        ]);
        exit;
    }
}