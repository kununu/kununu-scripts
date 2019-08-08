<?php

namespace Kununu\Scripts\PHPCodeStandards\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PHPCsFixerGitHookCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('kununu:cs-fixer-git-hook')
            ->setAliases(['cs-fixer-git-hook'])
            ->setDescription('Installs PHP CS Fixer Git Pre-Commit Hook');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('<info>' . $this->getName() . '</info> Appling PHP CS Fixer Git Pre-Commit Hook ....');
        $path = dirname($this->getComposer()->getConfig()->getConfigSource()->getName()) . '/..';

        $gitHooksPath = $path . '/.git/hooks';
        if (!is_dir($gitHooksPath)) {
            $this->getIO()->writeError('<error>GIT folder not found at ' . $gitHooksPath . '</error>');

            return;
        }

        // $currentFolder = dirname(__FILE__); Not sure if this is the same as below
        $currentFolder = __DIR__;

        copy($currentFolder . '/../php_cs', $gitHooksPath . '/.php_cs');
        copy($currentFolder . '/../git-pre-commit', $gitHooksPath . '/pre-commit');
        chmod($gitHooksPath . '/pre-commit', 0777);
        $csFixerExec = '../../services/vendor/kununu/scripts/vendor/bin/php-cs-fixer';
        unlink($csFixerExec);
        symlink($csFixerExec, $gitHooksPath . '/php-cs-fixer');

        $output->writeln('<info>' . $this->getName() . '</info> .... Git Hook Applied');
    }
}
