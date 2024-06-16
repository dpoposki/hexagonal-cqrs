<?php

namespace Poposki\Identity\Application\Messenger\Command;

use Poposki\Kernel\Application\Messenger\Command\CommandInterface;

final readonly class PasswordResetCommand implements CommandInterface
{
    public function __construct(
        private string $password,
        private string $token
    ) {
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
