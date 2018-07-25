<?php

use App\Bootstrap;

defined('PUBLIC_PATH') || define('PUBLIC_PATH', getenv('PUBLIC_PATH') ?: realpath(__DIR__));
defined('APP_PATH') || define('APP_PATH', realpath('../app'));
defined('APP_ENV') || define('APP_ENV', getenv('APP_ENV') ?: 'development');

require_once APP_PATH . '/../vendor/autoload.php';
require_once APP_PATH . '/Bootstrap.php';

echo (new Bootstrap())->init();
