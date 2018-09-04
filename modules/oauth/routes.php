<?php

$app->route('GET /oauth/login', 'OAuth\Controllers\OAuthController->login');
$app->route('GET /oauth/logout', 'OAuth\Controllers\OAuthController->logout');
$app->route('GET /oauth/example', 'OAuth\Controllers\OAuthController->example');