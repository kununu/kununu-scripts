<?php
namespace Kununu\Scripts\PHPCodeStandards\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

class PHPCsFixerGitHookCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('kununu:cs-fixer-git-hook')
            ->setAliases(['cs-fixer-git-hook'])
            ->setDescription('Installs PHP CS Fixer Git Pre-Commit Hook');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('<info>' . $this->getName() . '</info> Appling PHP CS Fixer Git Pre-Commit Hook');
        $this->getComposer()->
//        $path = $this->options->get('root-dir');
//
//        echo $path;
    }
}

