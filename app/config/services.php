<?php

/**
 * Shared configuration service
 */
/** @var Phalcon\Di $di */
$di->setShared('router', function () {
    $config = $this->getShared('config');

    $router = new \Phalcon\Mvc\Router(false);
    $router->removeExtraSlashes(true)
        ->setDefaultModule($config->application->moduleDefault);

    // mount module routes
    foreach (array_keys($config->application->modules->toArray()) as $module) {
        if (!is_file(APP_PATH . '/modules/' . $module . '/config/routers.php')) {
            continue;
        }

        $routers = require_once APP_PATH . '/modules/' . $module . '/config/routers.php';

        if (!empty($routers) && is_array($routers)) {
            foreach ($routers as $route) {
                $router->mount(new $route());
            }
        }
    }

    return $router;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getShared('config');
    $url = new \Phalcon\Mvc\Url();

    if (isset($config->application->baseUri)) {
        $url->setBaseUri($config->application->baseUri);
    }

    return $url;
});

$di->setShared('voltService', function ($view) {
    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $this);
    $directory = $this->getShared('config')->application->cacheDir . '/volt/';

    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $volt->setOptions([
        "compiledPath"      => $directory,
        "compiledSeparator" => "-",
        "compileAlways"     => true,
    ]);

    return $volt;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getShared('config');

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset,
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new \Phalcon\Mvc\Model\Metadata\Memory();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->setShared('flash', function () {
    return new \Phalcon\Flash\Direct([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();

    return $session;
});
