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

        $gitPath = $path . '/.git';
        if (!is_dir($gitPath)) {
            $this->getIO()->writeError('<error>GIT folder not found at "' . $gitPath . '"</error>');

            return;
        }

        $currentFolder = __DIR__;
        $this->addGitHook($gitPath, $currentFolder . '/../git-pre-commit', 'pre-commit');

        // Add php-cs-fixer rules to be available on .git folder.
        $this->addLinkToGitFolder(
            $gitPath,
            '../../services/vendor/kununu/scripts/src/PHPCodeStandards/php_cs',
            '.php_cs'
        );

        // Add php-cs-fixer bin to be available on .git folder.
        $this->addLinkToGitFolder(
            $gitPath,
            '../../services/vendor/kununu/scripts/vendor/bin/php-cs-fixer',
            'php-cs-fixer'
        );

        $output->writeln('<info>' . $this->getName() . '</info> .... Git Hook Applied');
    }

    private function addGitHook(string $gitPath, string $file, string $hookName): void
    {
        $hookPath = $gitPath . '/hooks/' . $hookName;
        if (is_file($hookPath)) {
            unlink($hookPath);
        }

        copy($file, $hookPath);
        chmod($hookPath, 0777);
    }

    private function addLinkToGitFolder(string $gitPath, string $origin, string $linkName): void
    {
        // In order to make it clear a folder is created named kununu with the dependencies for pre-commit.
        $kununuBinPath = $gitPath . '/kununu';
        if (!is_dir($kununuBinPath)) {
            mkdir($kununuBinPath);
        }

        $kununuLink = $kununuBinPath . '/' . $linkName;
        if (is_link($kununuLink)) {
            unlink($kununuLink);
        }

        symlink($origin, $kununuLink);
    }
}
