<?php

namespace Poposki\Identity\Domain\Entity;

use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

class UserPasswordReset implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;

    private ?int $id = null;

    private ?UserInterface $user;

    public function __construct(UserInterface $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;

        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
