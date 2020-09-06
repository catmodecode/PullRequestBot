<?php

use App\App;
use App\Facade\Response;

require_once __DIR__ . '/../vendor/autoload.php';

App::run();

if($_ENV['TELEGRAM_UID']>0) {
    Response::error('Uid already set', 400);
}

$telegram = App::$telegram;

$teleHook = $telegram->getWebhookUpdates();
$uid = $teleHook->get('message')->get('from')->get('id');

$messageResult = $telegram->sendMessage([
    'chat_id' => $uid,
    'text' => 'Your id is "' . $uid . '". Store it in .env TELEGRAM_UID section.'
]);

Response::success('ok' , 200, $messageResult);
