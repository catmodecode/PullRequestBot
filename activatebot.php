<?php

use App\App;

require_once __DIR__ . '/vendor/autoload.php';

App::run();

$telegram = App::$telegram;

$hookParams = ['url' => $_ENV['TELEGRAM_HOOK_URL']];
try {
    $result = $telegram->setWebhook($hookParams);
    echo "\nHook registered. Now send any message to bot, he will reply your uid\n";
} catch (Exception $e) {
    echo $e->getMessage();
}
