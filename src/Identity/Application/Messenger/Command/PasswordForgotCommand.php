<?php

namespace Poposki\Identity\Application\Messenger\Command;

use Poposki\Kernel\Application\Messenger\Command\CommandInterface;

final readonly class PasswordForgotCommand implements CommandInterface
{
    public function __construct(
        private string $email
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
