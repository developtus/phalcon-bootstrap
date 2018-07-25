<?php

namespace Backend\Routers;

use Phalcon\Mvc\Router\Group;

/**
 * Class Main
 * Basic router
 *
 * @package Backend\Routers
 */
class Main extends Group
{
    /**
     * Admin home page
     */
    const ADMIN = 'backendMainHome';

    /**
     * Routes with only controllers
     */
    const CONTROLLER = 'backendMainController';

    /**
     * Routes with action and/or params
     */
    const ACTION = 'backendMainAction';

    /**
     * Main router definitions
     */
    public function initialize(): void
    {
        $this->setPaths([
            'module' => 'Backend',
        ]);

        $this->setPrefix('/admin');

        $this->add('')->setName(self::ADMIN);

        $this->add(
            '/:controller',
            ['controller' => 1]
        )->setName(self::CONTROLLER);

        $this->add(
            '/:controller/:action/:params',
            [
                'controller' => 1,
                'action'     => 2,
                'params'     => 3,
            ]
        )->setName(self::ACTION);
    }
}
