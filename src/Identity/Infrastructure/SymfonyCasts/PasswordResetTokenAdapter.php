<?php

namespace Poposki\Identity\Infrastructure\SymfonyCasts;

use Poposki\Identity\Domain\Adapter\PasswordResetAdapterInterface;
use Poposki\Identity\Domain\Entity\UserInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

final readonly class PasswordResetTokenAdapter implements PasswordResetAdapterInterface
{
    public function __construct(
        private ResetPasswordHelperInterface $passwordHelper
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function generateToken(UserInterface $user): ResetPasswordToken
    {
        return $this->passwordHelper->generateResetToken($user);
    }

    /**
     * {@inheritDoc}
     */
    public function validateToken(string $token): UserInterface
    {
        return $this->passwordHelper->validateTokenAndFetchUser($token);
    }

    /**
     * {@inheritDoc}
     */
    public function removeToken(string $token): void
    {
        $this->passwordHelper->removeResetRequest($token);
    }
}
