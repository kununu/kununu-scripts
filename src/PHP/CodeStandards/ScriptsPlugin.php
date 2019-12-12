<?php

namespace Kununu\Scripts\PHP\CodeStandards;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Kununu\Scripts\PHP\CodeStandards\Command\PHPCsFixerGitHookCommand;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class ScriptsPlugin implements PluginInterface, EventSubscriberInterface, Capable
{
    /** @var Composer */
    protected $composer;

    /** @var IOInterface */
    protected $io;

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'install',
            ScriptEvents::POST_UPDATE_CMD  => 'update',
        ];
    }

    private function installDependencies(Event $event, $operations = []): void
    {
        $this->addPHPGitHooks();
    }

    private function addPHPGitHooks(): void
    {
        $command = new PHPCsFixerGitHookCommand();
        $command->setComposer($this->composer);
        $command->setIO($this->io);

        $command->run(new StringInput(''), new StreamOutput(fopen('php://stdout', 'w')));
    }

    public function install(Event $event): void
    {
        $this->update($event);
    }

    public function update(Event $event, $operations = []): void
    {
        $this->installDependencies($event, $operations);
    }

    public function getCapabilities()
    {
        return [
            CommandProvider::class => PHPCsFixerCommandProvider::class,
        ];
    }
}
