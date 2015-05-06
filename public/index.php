<?php

use LittleNinja\Lib\Router;

setlocale(LC_ALL, 'bg_BG');
date_default_timezone_set('Europe/Sofia');

require __DIR__ . '/../vendor/autoload.php';
include_once '../config/app.php';
include_once '../config/db.php';
include_once '../config/messages.php';

Router::router();
