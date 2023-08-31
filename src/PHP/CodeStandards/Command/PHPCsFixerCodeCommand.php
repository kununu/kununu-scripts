<?php
declare(strict_types=1);

namespace Kununu\Scripts\PHP\CodeStandards\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PHPCsFixerCodeCommand extends BaseCommand
{
    /** This can be a list of files or directories. */
    private const ARGUMENT = 'files';

    protected function configure(): void
    {
        $this
            ->setName('kununu:cs-fixer-code')
            ->setAliases(['cs-fixer-code'])
            ->setDescription('Applies PHP CS Fixer on a project folder or file')
            ->addArgument(self::ARGUMENT, InputArgument::IS_ARRAY);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $arguments = $input->getArgument(self::ARGUMENT);
        if ($arguments) {
            $files = implode(' ', $arguments);
            $vendorDir = $this->requireComposer()->getConfig()->get('vendor-dir');

            exec(
                $vendorDir . '/bin/php-cs-fixer fix --config ' . __DIR__ . '/../Scripts/php_cs ' . $files,
                $outputExec,
                $returnVar
            );

            if (0 != $returnVar) {
                $output->writeln('<error>Errors occurred please check output</error>');

                return 1;
            }

            if (count($outputExec)) {
                $output->writeln('<info>RESULT:</info>');
                $output->writeln($outputExec);
            } else {
                $output->writeln('<info>No files where affected</info>');
            }
        } else {
            $output->writeln('No files or directories where provided');
        }

        return 0;
    }
}
