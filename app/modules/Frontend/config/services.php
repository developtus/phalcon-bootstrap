<?php

/** @var Phalcon\Di $di */
$di->setShared('dispatcher', function () use ($di) {
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($di->getShared('eventsManager'));
    $dispatcher->setDefaultNamespace('Frontend\Controllers');
    $dispatcher->getEventsManager()->attach(
        "dispatch:beforeDispatchLoop",
        new \Core\Plugins\ParamsToArray()
    );

    return $dispatcher;
});

$di->setShared('view', function () {
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir(\Frontend\Module::PATH . '/Views/Default/scripts/')
        ->registerEngines([
            '.volt' => 'voltService',
        ]);

    return $view;
});
