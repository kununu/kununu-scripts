<?php
namespace Kununu\Scripts;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

class ScriptsPlugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'install',
            ScriptEvents::POST_UPDATE_CMD => 'update',
        ];
    }

    private function installDependencies(Event $event, $operations = [])
    {
//        echo 'Event<pre>';
//        print_r($event);
//        echo '</pre>';
//
//        echo 'Operations<pre>';
//        print_r($operations);
//        echo '</pre>';
//
//        echo '<pre>';
//        print_r($event->getComposer()->getConfig());
//        echo '</pre>';
//        die;

        echo '-------------- OLA --------------------', PHP_EOL;
        $this->addPHPHooks();
    }

    private function addPHPHooks()
    {
        echo '-------------- addPHPHooks --------------------', PHP_EOL;
    }

    public function install(Event $event)
    {
        $this->update($event);
    }

    public function update(Event $event, $operations = [])
    {
        $this->installDependencies($event, $operations);
    }
}

