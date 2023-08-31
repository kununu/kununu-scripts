<?php
declare(strict_types=1);

namespace Kununu\Scripts\PHP\CodeStandards;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Kununu\Scripts\PHP\CodeStandards\Command\PHPCsFixerGitHookCommand;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

final class ScriptsPlugin implements PluginInterface, EventSubscriberInterface, Capable
{
    private Composer $composer;
    private IOInterface $io;

    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'addPHPGitHooks',
            ScriptEvents::POST_UPDATE_CMD  => 'addPHPGitHooks',
        ];
    }

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }

    public function getCapabilities(): array
    {
        return [
            CommandProvider::class => PHPCsFixerCommandProvider::class,
        ];
    }

    public function addPHPGitHooks(): void
    {
        $command = new PHPCsFixerGitHookCommand();
        $command->setComposer($this->composer);
        $command->setIO($this->io);

        $command->run(new StringInput(''), new StreamOutput(fopen('php://stdout', 'w')));
    }
}
