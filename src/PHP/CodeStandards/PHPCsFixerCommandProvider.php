<?php
declare(strict_types=1);

namespace Kununu\Scripts\PHP\CodeStandards;

use Composer\Plugin\Capability\CommandProvider;
use Kununu\Scripts\PHP\CodeStandards\Command\PHPCsFixerCodeCommand;
use Kununu\Scripts\PHP\CodeStandards\Command\PHPCsFixerGitHookCommand;

final class PHPCsFixerCommandProvider implements CommandProvider
{
    public function getCommands(): array
    {
        return [
            new PHPCsFixerCodeCommand(),
            new PHPCsFixerGitHookCommand(),
        ];
    }
}
