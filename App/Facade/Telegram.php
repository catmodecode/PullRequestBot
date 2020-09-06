<?php

namespace App\Facade;

use App\App;

class Telegram
{
    private static $userId;

    /**
     * Send message to user stored in .env TELEGRAM_UID;
     * 
     * @param string $text
     * 
     * @return array
     */
    public static function send(string $text)
    {
        if (!isset(Telegram::$userId)) {
            Telegram::$userId = $_ENV['TELEGRAM_UID'];
        }

        return App::$telegram->sendMessage([
            'chat_id' => Telegram::$userId,
            'text' => $text
        ]);
    }
}
