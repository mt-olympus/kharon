<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        'factories' => [
            Person\Action\DashboardAction::class => Person\Action\Factory\DashboardActionFactory::class,
            Person\Action\HasMacAction::class => Person\Action\Factory\HasMacActionFactory::class,
            Person\Action\AddCompanyAction::class => Person\Action\Factory\AddCompanyActionFactory::class,
            Person\Action\LoginAction::class => Person\Action\Factory\LoginActionFactory::class,
            Person\Action\PersonAction::class => Person\Action\Factory\PersonActionFactory::class,
            Person\Action\UpsertAction::class => Person\Action\Factory\UpsertActionFactory::class,
            Person\Action\ProviderAction::class => Person\Action\Factory\ProviderActionFactory::class,
        ],
    ],

    'console' => [
        'routes' => [
            [
                'name' => 'hermes <path> <zeus> [--quiet|--q] [--verbose|-v]',
                'handler' => Kharon\Console\ExportEs::class,
            ]
        ],
    ],
];
