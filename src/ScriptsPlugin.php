<?php

namespace Kununu\Scripts;

use Composer\Composer;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Repository\InstalledArrayRepository;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Composer\Semver\Constraint\EmptyConstraint;
use Kununu\Scripts\PHPCodeStandards\Command\PHPCsFixerGitHookCommand;
use Kununu\Scripts\PHPCodeStandards\PHPCsFixerCommandProvider;
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

//        $composer->getEventDispatcher()->dispatch()
//        $this->composer->getInstallationManager()->();
//        $this->composer->getAutoloadGenerator()
//        foreach ($this->composer->getRepositoryManager()->getRepositories() as $repository) {
//            if ($repository->)
//            foreach ($repository->getPackages() as $package) {
//                echo $package->getName(), ' ', $package->getVersion(), PHP_EOL;
//            }
//        }

//        $package = $this->composer->getRepositoryManager()->getLocalRepository()->findPackage('kununu/scripts', 'v1.0');
//

//        $package = $this->composer->getRepositoryManager()->findPackage('kununu/scripts', new EmptyConstraint());
//        $packages = $package->getRepository()->getPackages();
//
//        $this->composer->getInstallationManager()
//            ->getInstaller($package->getType())
//            ->update(new InstalledArrayRepository($packages), new UpdateOperation($package, array_pop($packages)));
////        $this->composer->getInstallationManager()->(new InstalledArrayRepository($packages), new UpdateOperation($package, array_pop($packages)));
//            die('aaa');
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
