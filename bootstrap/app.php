<?php

require __DIR__.'/../vendor/autoload.php';

$app = Base::instance();

Modules::run();

return $app;