<?php

define('LN_DS', DIRECTORY_SEPARATOR);
define('LN_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('LN_ROOT_DIR', dirname(dirname(__FILE__ . '/')));
define('LN_ROOT_PATH', dirname(basename(dirname(__FILE__)) . '/'));
define('LN_PATH_VIEW', LN_ROOT_DIR . '/app/views/');
define('LN_DEFAULT_CONTROLLER', 'home');
define('LN_DEFAULT_ACTION', 'index');
define('LN_DEFAULT_PAGE_SIZE', 5);

// SEO
define('LN_SITE_NAME', 'LittleNinja\'s Blog');
define('LN_SITE_DESCRIPTION', 'Блогът на малкия нинджа developer!');
define('LN_SITE_KEYWORDS', 'HTML, CSS, C#, C, IT, Technology, Programming, Windows, Програмиране, Технологии, ИТ');
