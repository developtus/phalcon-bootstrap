<?php

return [
    'debug'       => true,
    'database'    => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'test',
        'charset'  => 'utf8',
    ],
    'application' => [
        'appDir'        => APP_PATH . '/',
        'libraryDir'    => APP_PATH . '/library/',
        'cacheDir'      => APP_PATH . '/../cache/',
        'modules'       => [
            'Frontend' => [
                'className' => Frontend\Module::class,
                'path'      => APP_PATH . '/modules/Frontend/Module.php',
            ],
            'Backend'  => [
                'className' => Backend\Module::class,
                'path'      => APP_PATH . '/modules/Backend/Module.php',
            ],
        ],
        'moduleDefault' => 'Frontend',
        'namespaces'    => [
            'Core'     => APP_PATH . '/modules/Core/',
            'Frontend' => APP_PATH . '/modules/Frontend/',
            'Backend'  => APP_PATH . '/modules/Backend/',
        ],
    ],
    'orm' => [
        'castOnHydrate'      => true,
        'notNullValidations' => false,
    ]
];
