<?php

namespace Poposki\Identity\Domain\Adapter;

use Poposki\Identity\Domain\Entity\UserInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

interface PasswordResetAdapterInterface
{
    /**
     * @param UserInterface $user
     * @return ResetPasswordToken
     * @throws ResetPasswordExceptionInterface
     */
    public function generateToken(UserInterface $user): ResetPasswordToken;

    /**
     * @param string $token
     * @return UserInterface
     * @throws ResetPasswordExceptionInterface
     */
    public function validateToken(string $token): UserInterface;

    /**
     * @param string $token
     * @return void
     */
    public function removeToken(string $token): void;
}
