<?php

namespace Frontend;

use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Class Module
 * Setup backend module
 *
 * @package Backend
 */
class Module implements ModuleDefinitionInterface
{
    /**
     * Module base directory
     */
    const PATH = __DIR__;

    /**
     * Registers the module auto-loader
     *
     * @param DiInterface|null $di
     */
    public function registerAutoloaders(DiInterface $di = null): void
    {
    }

    /**
     * Registers the module-only services
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di): void
    {
        $di->getShared('config')->merge(new Config(require_once self::PATH . "/config/config.php"));

        require_once self::PATH . "/config/services.php";
    }
}
