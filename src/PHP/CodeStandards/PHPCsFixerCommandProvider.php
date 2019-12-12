<?php

namespace Kununu\Scripts\PHP\CodeStandards;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Kununu\Scripts\PHPCodeStandards\Command\PHPCsFixerCodeCommand;
use Kununu\Scripts\PHPCodeStandards\Command\PHPCsFixerGitHookCommand;

class PHPCsFixerCommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return [
            new PHPCsFixerCodeCommand(),
            new PHPCsFixerGitHookCommand(),
        ];
    }
}
