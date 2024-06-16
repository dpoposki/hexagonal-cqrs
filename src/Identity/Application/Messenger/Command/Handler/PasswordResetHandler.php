<?php

namespace Poposki\Identity\Application\Messenger\Command\Handler;

use Poposki\Identity\Application\Messenger\Command\PasswordResetCommand;
use Poposki\Identity\Domain\Adapter\PasswordResetAdapterInterface;
use Poposki\Identity\Domain\Repository\UserRepositoryInterface;
use Poposki\Kernel\Application\Messenger\Command\CommandHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

readonly class PasswordResetHandler implements CommandHandlerInterface
{
    public function __construct(
        private PasswordResetAdapterInterface $passwordResetAdapter,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param PasswordResetCommand $command
     * @return void
     * @throws ResetPasswordExceptionInterface
     */
    public function __invoke(PasswordResetCommand $command): void
    {
        $token = $command->getToken();

        $user = $this->passwordResetAdapter->validateToken($token);

        // A password reset token should be used only once, remove it.
        $this->passwordResetAdapter->removeToken($token);

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $command->getPassword()
            )
        );

        $this->userRepository->add($user);
    }
}
