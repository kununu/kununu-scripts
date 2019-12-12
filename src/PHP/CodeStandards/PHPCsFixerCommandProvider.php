<?php

namespace Kununu\Scripts\PHP\CodeStandards;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Kununu\Scripts\PHP\CodeStandards\Command\PHPCsFixerCodeCommand;
use Kununu\Scripts\PHP\CodeStandards\Command\PHPCsFixerGitHookCommand;

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
