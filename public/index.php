<?php

use LittleNinja\Lib\Router;

require __DIR__ . '/../vendor/autoload.php';
include_once '../config/app.php';
include_once '../config/db.php';
include_once '../config/messages.php';

Router::router();
