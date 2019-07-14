<?php

namespace Kununu\Scripts\PHPCodeStandards\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PHPCsFixerCodeCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('kununu:cs-fixer-code')
            ->setAliases(['cs-fixer-code'])
            ->setDescription('Applies PHP CS Fixer on a project folder or file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Work in progress');
    }
}
