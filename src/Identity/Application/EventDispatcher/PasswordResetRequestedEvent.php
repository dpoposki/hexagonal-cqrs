<?php

namespace Poposki\Identity\Application\EventDispatcher;

use Poposki\Kernel\Application\EventDispatcher\Event;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

class PasswordResetRequestedEvent extends Event
{
    public function __construct(
        private readonly string $email,
        private readonly ResetPasswordToken $token
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getToken(): ResetPasswordToken
    {
        return $this->token;
    }
}
