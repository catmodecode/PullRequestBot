<?php

$app = require_once __DIR__ . '/app.php';

$app->run();

$telegram = $app->telegram;

$hookParams = ['url' => $_ENV['TELEGRAM_HOOK_URL']];
$result = $telegram->setWebhook($hookParams);

echo "\nHook registered. Now send any message to bot, he will reply your uid\n";
