<?php

$app = require_once __DIR__ . '/../app.php';

$app->run();

$input = file_get_contents('php://input');

echo 'OK!';