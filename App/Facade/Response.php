<?php

namespace App\Facade;

class Response {
    public static function json($data, $status = 200){
        http_response_code($status);
        echo json_encode($data);
    }
}