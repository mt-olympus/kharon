<?php
namespace Kharon\Controller;

use Hermes\Api\Client;
use Kharon\Version;
use Ramsey\Uuid\Uuid;
use Zend\Console\ColorInterface as Color;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ConsoleModel;

abstract class BaseController extends AbstractActionController
{
    abstract function getPath();

    public function versionAction()
    {
        $console = $this->getServiceLocator()->get('console');

        $console->writeLine('Kharon', Color::GREEN);
        $console->writeLine(Version::VERSION);
    }

    protected function send($data, $url)
    {
        $client = new \Zend\Http\Client($url, [
            'timeout'       => 60,
            'sslverifypeer' => false,
            'keepalive'     => true,
            'adapter'       => 'Zend\Http\Client\Adapter\Socket',
        ]);
        $client->getRequest()->getHeaders()->addHeaders([
            'Accept'       => 'application/hal+json',
            'Content-Type' => 'application/json',
            'User-Agent'   => 'kharon',
            'X-Request-Name' => 'kharon',
        ]);

        $hermes = new Client($client);
        $hermes->addRequestId('zeus');
        try {
            $hermes->post($this->getPath(), $data);
        } catch (\Exception $ex) {
            return false;
        }

        return true;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $dir = $request->getParam('directory');
        $zeus = $request->getParam('zeus');

        if (!file_exists($dir)) {
            $m = new ConsoleModel();
            $m->setErrorLevel(2);
            $m->setResult("Directory '$dir' not found." . PHP_EOL);
            return $m;
        }

        foreach (glob($dir.'/*.kharon') as $filename) {
            $data = file_get_contents($filename);
            if ($this->send($data, $zeus)) {
                unlink($filename);
            } else {
                rename($filename, $filename.'.err');
            }
        }
    }
}
