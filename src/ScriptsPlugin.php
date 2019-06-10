<?php
namespace Kununu\Scripts;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;

class ScriptsPlugin implements PluginInterface, EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'install',
            ScriptEvents::POST_UPDATE_CMD => 'update',
        ];
    }

    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new TemplateInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }

    private function installPlugin(Event $event, $operations = [])
    {
        echo 'Event<pre>';
        print_r($event);
        echo '</pre>';

        echo 'Operations<pre>';
        print_r($operations);
        echo '</pre>';

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
        $this->installPlugin($event, $operations);
    }
}
