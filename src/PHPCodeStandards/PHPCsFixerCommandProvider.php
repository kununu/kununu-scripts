<?php
namespace Kununu\Scripts\PHPCodeStandards;

use Kununu\Scripts\PHPCodeStandards\Command\PHPCsFixerCodeCommand;
use Kununu\Scripts\PHPCodeStandards\Command\PHPCsFixerGitHookCommand;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Composer\Command\BaseCommand;

class PHPCsFixerCommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return [
            new PHPCsFixerCodeCommand(),
            new PHPCsFixerGitHookCommand()
        ];
    }
}
