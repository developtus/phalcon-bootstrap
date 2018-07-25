<?php

/** @var Phalcon\Di $di */
$di->setShared('dispatcher', function () {
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($this->getShared('eventsManager'));
    $dispatcher->setDefaultNamespace('Backend\Controllers');
    $dispatcher->getEventsManager()->attach(
        "dispatch:beforeDispatchLoop",
        new \Core\Plugins\ParamsToArray()
    );

    return $dispatcher;
});

$di->setShared('view', function () {
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir(\Backend\Module::PATH . '/Views/Default/scripts/')
        ->registerEngines([
            ".volt" => 'voltService',
        ]);

    return $view;
});
