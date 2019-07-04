<?php
namespace Kununu\Scripts\PHPCodeStandards\Command;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

class PHPCsFixerCodeCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('kununu:cs-fixer-code')
            ->setAliases(['cs-fixer-code'])
            ->setDescription('Applies PHP CS Fixer on a project folder or file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Work in progress');
    }
}
