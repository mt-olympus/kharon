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

        if (!file_exists($path)) {
            $console->writeLine("Path $path not found.", ColorInterface::RED);
            return;
        }

        $this->apiClient->getZendClient()->setUri($zeusUrl);

        foreach (glob($path.'/*.kharon') as $filename) {
            if ($verbose) {
                $console->write("Sending $filename ... ");
            }
            $data = file_get_contents($filename);
            $success = $this->send($data, sprintf('/v1/%s/collect', $type));
            if ($verbose) {
                if ($success) {
                    $console->writeLine("OK", ColorInterface::GREEN);
                } else {
                    $console->writeLine("FAILED", ColorInterface::RED);
                }
            }
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
