<?php

$app->route('GET @getSignup: /auth/signup', 'Auth\Controllers\SignupController->get');
$app->route('POST @signup: /auth/signup', 'Auth\Controllers\SignupController->post');

$app->route('GET @getSignin: /auth/signin', 'Auth\Controllers\SigninController->get');
$app->route('POST @signin: /auth/signin', 'Auth\Controllers\SigninController->post');

$app->route('GET @signout: /auth/signout', 'Auth\Controllers\SignoutController->get');

$app->route('GET @getReset: /auth/password/reset', 'Auth\Controllers\ForgotPasswordController->get');
$app->route('POST @sendResetEmail: /auth/password/reset/email', 'Auth\Controllers\ForgotPasswordController->post');
$app->route('GET @getResetToken: /auth/password/reset/@token', 'Auth\Controllers\ResetPasswordController->get');
$app->route('POST @reset: /auth/password/reset', 'Auth\Controllers\ResetPasswordController->post');
