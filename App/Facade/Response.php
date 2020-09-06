<?php

namespace App\Facade;

class Response
{

    /**
     * Reply json response and die
     * 
     * @param mixed $data
     * @param int $status
     * 
     * @return void
     */
    public static function json($data, $status = 200): void
    {
        http_response_code($status);
        echo json_encode($data);
        die();
    }

    /**
     * @param string $message
     * @param mixed $data
     * @param int $status
     * 
     * @return void
     */
    public static function success(string $message, $status = 200, $data = []): void
    {
        http_response_code($status);
        echo json_encode(['status' => 'success', 'success' => $message, 'data' => $data]);
        die();
    }

    /**
     * @param string $message
     * @param mixed $data
     * @param int $status
     * 
     * @return void
     */
    public static function error(string $message, $status = 400, $data = []): void
    {
        http_response_code($status);
        echo json_encode(['status' => 'error', 'error' => $message, 'data' => $data]);
        die();
    }
}
