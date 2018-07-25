<?php

namespace Frontend\Routers;

use Phalcon\Mvc\Router\Group;

/**
 * Class Main
 * Basic router
 *
 * @package Frontend\Routers
 */
class Main extends Group
{
    /**
     * Home page
     */
    const HOME = 'frontendMainHome';

    /**
     * Routes with only controllers
     */
    const CONTROLLER = 'frontendMainController';

    /**
     * Routes with action and/or params
     */
    const ACTION = 'frontendMainAction';

    /**
     * Main router definitions
     */
    public function initialize(): void
    {
        $this->setPrefix('/');

        $this->add('')->setName(self::HOME);

        $this->add(
            ':controller',
            ['controller' => 1]
        )->setName(self::CONTROLLER);

        $this->add(
            ':controller/:action/:params',
            [
                'controller' => 1,
                'action'     => 2,
                'params'     => 3,
            ]
        )->setName(self::ACTION);
    }
}
