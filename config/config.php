<?php
return [
    'hermes' => [
        'uri' => '',
        'append_path' => true,
        'collector' => false,
        'depth' => 10,
        'headers' => [
            'Accept'       => 'application/hal+json',
            'Content-Type' => 'application/json',
            'User-Agent'   => 'kharon/' . Kharon\Version::VERSION,
            'X-Request-Name' => 'kharon',
        ],
        'http_client' => [
            'options' => [
                'timeout'       => 60,
                'sslverifypeer' => false,
                'keepalive'     => true,
                'adapter'       => 'Zend\Http\Client\Adapter\Socket',
            ],
        ],
    ],
    'dependencies' => [
        'invokables' => [
        ],
        'factories' => [
            Kharon\Console\Upload::class => Kharon\Console\Factory\UploadFactory::class,
        ],
    ],

    'console' => [
        'routes' => [
            [
                'name' => 'upload [hermes|artemis|lachesis] <path> <zeus> [--quiet|--q] [--verbose|-v]',
                'handler' => Kharon\Console\Upload::class,
            ]
        ],
    ],
];
