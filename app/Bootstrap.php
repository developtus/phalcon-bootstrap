<?php

namespace App;

use Phalcon\Config;
use Phalcon\Debug;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Model;

/**
 * Class Bootstrap
 */
class Bootstrap extends Application
{
    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        // init DI and config service
        $this->setDI(new FactoryDefault());

        // general configuration
        $config = new Config(require_once APP_PATH . '/config/config.php');
        $this->getDI()->setShared('config', $config);

        // ORM setup
        Model::setup($config->orm->toArray());

        // register services
        $this->registerServices();

        // register modules
        $this->registerModules($config->application->modules->toArray());
        $this->setDefaultModule($config->application->moduleDefault);
    }

    /**
     * Services registry
     */
    private function registerServices(): void
    {
        $di = $this->getDI();
        $config = $this->getDI()->getShared('config');

        // custom config by environment?
        if (is_file(APP_PATH . '/config/config.' . APP_ENV . '.php')) {
            $config->merge(new Config(require_once APP_PATH . '/config/config.' . APP_ENV . '.php'));
        }

        // debug mode?
        if ($config->get('debug', false) === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            (new Debug())->listen(true, true);
        }

        require_once APP_PATH . '/config/loader.php';
        require_once APP_PATH . '/config/services.php';
    }

    /**
     * Init
     * @return string
     */
    public function init(): string
    {
        mb_internal_encoding('UTF-8');
        mb_http_output('UTF-8');

        return $this->handle()->getContent();
    }
}
