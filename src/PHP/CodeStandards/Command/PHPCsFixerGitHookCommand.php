<?php

namespace Kununu\Scripts\PHP\CodeStandards\Command;

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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>' . $this->getName() . '</info> Applying PHP CS Fixer Git Pre-Commit Hook ....');

        exec('git rev-parse --show-toplevel', $outputExec, $returnVar);
        if (0 != $returnVar || !isset($outputExec[0])) {
            $output->writeln('<error>GIT is not available</error>');

            return 1;
        }

        $gitPath = $outputExec[0] . '/.git';
        if (!is_dir($outputExec[0])) {
            $output->writeln('<error>GIT folder not found at "' . $gitPath . '"</error>');

            return 1;
        }

        $currentFolder = __DIR__;
        $this->addGitHook($gitPath, $currentFolder . '/../Scripts/git-pre-commit', 'pre-commit');

        // Add php-cs-fixer rules to be available on .git folder.
        $vendorDir = is_dir(sprintf('%s/services/vendor', $outputExec[0])) ? '../../services/vendor' : '../../vendor';

        $this->addLinkToGitFolder(
            $gitPath,
            sprintf('%s/kununu/scripts/src/PHP/CodeStandards/Scripts/php_cs', $vendorDir),
            '.php-cs-fixer.php'
        );

        // Add php-cs-fixer bin to be available on .git folder.
        $this->addLinkToGitFolder(
            $gitPath,
            sprintf('%s/bin/php-cs-fixer', $vendorDir),
            'php-cs-fixer'
        );

        $output->writeln('<info>' . $this->getName() . '</info> .... Git Hook Applied');

        return 0;
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
