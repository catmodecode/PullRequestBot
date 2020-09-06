<?php

use App\App;
use App\Facade\Response;
use App\Facade\Telegram;

require_once __DIR__ . '/../vendor/autoload.php';

App::run();

$gitHook = App::$gitHook;
$telegram = App::$telegram;

$message = $gitHook->getWebhook()->getMessage();
$sendResult = Telegram::send($message);

Response::json(['status' => 'ok']);