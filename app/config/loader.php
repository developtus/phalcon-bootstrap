<?php
/** @var Phalcon\Config $config */
$loader = new \Phalcon\Loader();
$loader->registerNamespaces($config->application->namespaces->toArray());
$loader->register();
