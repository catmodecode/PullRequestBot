<?php

use App\App;
use App\Facade\Response;
use App\Facade\Telegram;

require_once __DIR__ . '/../vendor/autoload.php';

App::run();

$gitHook = App::$gitHook;
$telegram = App::$telegram;

try {
    $message = $gitHook->getWebhook()->getMessage();
} catch (JsonException $e) {
    Response::exception($e, 417);
} catch (Exception $e) {
    Response::exception($e, 418);
}

$sendResult = Telegram::send($message);

Response::success('ok');