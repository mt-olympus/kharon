<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Kharon\Controller\Hermes' => 'Kharon\Controller\HermesController',
            'Kharon\Controller\Artemis' => 'Kharon\Controller\ArtemisController',
            'Kharon\Controller\Lachesis' => 'Kharon\Controller\LachesisController',
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'version' => array(
                    'options' => array(
                        'route'    => 'version',
                        'defaults' => array(
                            'controller' => 'Kharon\Controller\Index',
                            'action'     => 'version',
                        ),
                    ),
                ),
                'version2' => array(
                    'options' => array(
                        'route'    => '--version',
                        'defaults' => array(
                            'controller' => 'Kharon\Controller\Index',
                            'action'     => 'version',
                        ),
                    ),
                ),
                'hermes' => array(
                    'options' => array(
                        'route'    => 'hermes <directory> <zeus> [--quiet|-q] [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'Kharon\Controller\Hermes',
                            'action'     => 'index',
                        ),
                    ),
                ),
                'artemis' => array(
                    'options' => array(
                        'route'    => 'artemis <directory> <zeus> [--quiet|-q] [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'Kharon\Controller\Artemis',
                            'action'     => 'index',
                        ),
                    ),
                ),
                'lachesis' => array(
                    'options' => array(
                        'route'    => 'lachesis <directory> <zeus> [--quiet|-q] [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'Kharon\Controller\Lachesis',
                            'action'     => 'index',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
