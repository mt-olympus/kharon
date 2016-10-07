<?php
namespace Kharon\Console;

use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\Request;
use Zend\Console\ColorInterface;
use ZF\Console\Route;
use Hermes\Api\Client;

class Upload
{
    private $apiClient;
    private $request;

    public function __construct(Client $apiClient, Request $request)
    {
        $this->apiClient = $apiClient;
        $this->request = $request;
    }

    public function __invoke(Route $route, AdapterInterface $console)
    {
        $params = $this->request->getContent();
        $type = $params[1] ?? null;
        $path = $params[2] ?? null;
        $zeusUrl = $params[3] ?? null;

        $opts = $route->getMatches();
        $verbose = $opts['verbose'] || $opts['v'];
        //$quiet = $opts['quiet'] || $opts['q'];

        if (!file_exists($path)) {
            $console->writeLine("Path $path not found.", ColorInterface::RED);
            return;
        }

        $this->apiClient->getZendClient()->setUri($zeusUrl);

        foreach (glob($path.'/*.kharon') as $filename) {
            if ($verbose) {
                $console->writeLine("Sending $filename ...", ColorInterface::BLUE);
            }
            $data = file_get_contents($filename);
            $this->send($data, sprintf('/v1/%s/collect', $type));
            unlink($filename);
        }
        if ($verbose) {
            $console->writeLine('Done.', ColorInterface::GREEN);
        }
    }

    private function send($data, $url)
    {
        try {
            $this->apiClient->post($url, $data);
            return true;
        } catch (\Exception $ex) {}
        return false;
    }
}
