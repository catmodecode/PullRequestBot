<?php

namespace App;

use Dotenv\Dotenv;
use GitHook\GitHook;
use Telegram\Bot\Api as Telegram;

class App
{
    public static Telegram $telegram;
    public static GitHook $gitHook;
    
    public static function run()
    {
        Dotenv::createImmutable(__DIR__ . '/..')->load();

        App::$telegram = new Telegram($_ENV['TELEGRAM_SECRET']);
        App::$gitHook = new GitHook($_ENV['GITHUB_SECRET']);
    }
};
