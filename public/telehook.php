<?php

$app = require_once __DIR__ . '/../app.php';
$app->run();

if($_ENV['TELEGRAM_UID']>0) {
    die();
}

$telegram = $app->telegram;

$r = $telegram->getWebhookUpdates();
$uid = $r->get('message')->get('from')->get('id');

$telegram->sendMessage([
    'chat_id' => $uid,
    'text' => 'Your id is "' . $uid . '". Store it in .env TELEGRAM_UID section.'
]);
