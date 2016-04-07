<?php
namespace Kharon\Controller;

use Zend\View\Model\ConsoleModel;

class AllController extends BaseController
{
    private $path;

    /**
     *
     * {@inheritDoc}
     *
     * @see \Kharon\Controller\BaseController::getPath()
     */
    public function getPath()
    {
        return $this->path;
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

        foreach (['hermes', 'lachesis', 'artemis'] as $source) {
            $this->path = "/$source/collect";
            foreach (glob($dir.'/'.$source.'/*.kharon') as $filename) {
                $data = file_get_contents($filename);
                if ($this->send($data, $zeus)) {
                    unlink($filename);
                } else {
                    rename($filename, $filename.'.err');
                }
            }
        }
    }
}