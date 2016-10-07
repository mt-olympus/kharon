<?php
namespace Kharon\Console\Factory;

use Interop\Container\ContainerInterface;
use Kharon\Console\Upload;
use Zend\Console\Request;
use Zend\ServiceManager\Factory\FactoryInterface;
use Hermes\Api\ClientFactory;
use Hermes\Api\Client;

class UploadFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hermes = (new ClientFactory())->__invoke($container, Client::class);
        $hermes->setAppendPath(false);
        $hermes->addRequestId('kharon');

        $request = new Request();

        return new Upload($hermes, $request);
    }
}
