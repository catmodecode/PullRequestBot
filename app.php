<?php

use Telegram\Bot\Api as Telegram;

return new class
{
    public Telegram $telegram;
    
    public function run()
    {
        require_once __DIR__ . '/vendor/autoload.php';

        Dotenv\Dotenv::createImmutable(__DIR__)->load();

        $this->telegram = new Telegram($_ENV['TELEGRAM_SECRET']);
    }
};
