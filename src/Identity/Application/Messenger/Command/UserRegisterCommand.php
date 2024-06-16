<?php

namespace Poposki\Identity\Application\Messenger\Command;

use Poposki\Kernel\Application\Messenger\Command\CommandInterface;

final readonly class UserRegisterCommand implements CommandInterface
{
    public function __construct(
        private string $email,
        private string $password
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): string
    {
        return $this->password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
