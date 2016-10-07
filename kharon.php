#!/usr/bin/env php
<?php

$basePath = Phar::running(true);
if ($basePath == '') {
    $basePath = __DIR__;
    chdir($basePath);
}

require_once $basePath . '/vendor/autoload.php';
$config = require_once $basePath . '/config/config.php';

$container = new \Zend\ServiceManager\ServiceManager();
(new \Zend\ServiceManager\Config($config['dependencies'] ?? []))->configureServiceManager($container);

$container->setService('config', $config);


$dispatcher = new \ZF\Console\Dispatcher($container);

$routes = $config['console']['routes'] ?? [];

$application = new \ZF\Console\Application(
    'Kharon',
    Kharon\Version::VERSION,
    $routes,
    \Zend\Console\Console::getInstance(),
    $dispatcher
);
$exit = $application->run();
exit($exit);
