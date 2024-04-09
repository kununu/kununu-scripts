<?php
declare(strict_types=1);

namespace Kununu\Scripts\PHP\CodeStandards\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PHPCsFixerGitHookCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('kununu:cs-fixer-git-hook')
            ->setAliases(['cs-fixer-git-hook'])
            ->setDescription('Installs PHP CS Fixer Git Pre-Commit Hook');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(sprintf('<info>%s</info> Applying PHP CS Fixer Git Pre-Commit Hook...', $this->getName()));

        exec('git rev-parse --show-toplevel', $outputExec, $returnVar);
        if (0 !== $returnVar || !isset($outputExec[0])) {
            $output->writeln('<error>GIT is not available</error>');

            return 1;
        }

        $gitPath = sprintf('%s/.git', $outputExec[0]);
        if (!is_dir($outputExec[0])) {
            $output->writeln(sprintf('<error>GIT folder not found at "%s"</error>', $gitPath));

            return 1;
        }

        $currentFolder = __DIR__;
        $this->addGitHook($gitPath, sprintf('%s/../Scripts/git-pre-commit', $currentFolder));

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

        $output->writeln(sprintf('<info>%s</info> Git Hook Applied', $this->getName()));

        return 0;
    }

    private function addGitHook(string $gitPath, string $file): void
    {
        $hooksDir = sprintf('%s/hooks', $gitPath);
        if (!is_dir($hooksDir)) {
            mkdir($hooksDir);
        }

        $hookPath = sprintf('%s/pre-commit', $hooksDir);
        if (is_file($hookPath)) {
            unlink($hookPath);
        }

        copy($file, $hookPath);
        chmod($hookPath, 0777);
    }

    private function addLinkToGitFolder(string $gitPath, string $origin, string $linkName): void
    {
        // In order to make it clear a folder is created named kununu with the dependencies for pre-commit.
        $kununuBinPath = sprintf('%s/kununu', $gitPath);
        if (!is_dir($kununuBinPath)) {
            mkdir($kununuBinPath);
        }

        $kununuLink = sprintf('%s/%s', $kununuBinPath, $linkName);
        if (is_link($kununuLink)) {
            unlink($kununuLink);
        }

        symlink($origin, $kununuLink);
    }
}
