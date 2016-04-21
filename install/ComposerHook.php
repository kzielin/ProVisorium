<?php

namespace Install;

use Composer\IO\IOInterface;
use Composer\Script\Event;

use Install\Minifier\CSS;
use MatthiasMullie\Minify;
use Less_Parser;

class ComposerHook
{

    /**
     * @var IOInterface
     */
    protected $io;
    /**
     * @var Event
     */
    private $event;
    /**
     * ComposerHook constructor.
     *
     * @param $rootDirectory
     * @param Event $event
     */
    public function __construct($rootDirectory, Event $event)
    {
        $this->rootDirectory = $rootDirectory;
        define('APP_DIR',$this->rootDirectory.'/app/');
        $this->io = $event->getIO();
        $this->event = $event;
    }
    /**
     * @param Event $event
     */
    public static function postUpdate(Event $event)
    {
        $hook = new static(getcwd(), $event);
        $hook->compileLess();
        $hook->minifyCSS();
        $hook->minifyJS();
        $hook->warmUpTemplates();
    }
    protected function compileLess()
    {

        $this->io->write('Compiling less files...');

        $srcDir = $this->rootDirectory.'/app/src/less/';
        $destDir = $this->rootDirectory.'/assets/css/';

        $parser = new Less_Parser();
        $fileList = glob($srcDir . '*.less');
        foreach ($fileList as $fileName) {
            $destPath = $destDir.basename($fileName, '.less').'.css';
            $parser->parseFile($srcDir, '/assets/img/');
            file_put_contents($destPath, $parser->getCss());
        }
        
    }

    private function minifyCSS()
    {
        $this->io->write('Minifying CSS files...');

        $minifier = new CSS;
        $srcDir = $this->rootDirectory.'/assets/css/';
        $destDir = $this->rootDirectory.'/assets/css/';
    }

    private function minifyJS()
    {
        $this->io->write('Minifying JS files...');

        $minifier = new Minify\JS();
        $srcDir = $this->rootDirectory.'/app/src/js/';
        $destDir = $this->rootDirectory.'/assets/js/';
    }

    private function warmUpTemplates()
    {
        $this->io->write('Clearing Smarty cache...');
        $srcDir = $this->rootDirectory.'/cache/smarty/compile/*.tpl.php';
    }
}