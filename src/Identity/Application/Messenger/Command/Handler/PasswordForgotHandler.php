<?php

namespace Poposki\Identity\Application\Messenger\Command\Handler;

use Poposki\Identity\Application\EventDispatcher\PasswordResetRequestedEvent;
use Poposki\Identity\Application\Messenger\Command\PasswordForgotCommand;
use Poposki\Identity\Domain\Adapter\PasswordResetAdapterInterface;
use Poposki\Identity\Domain\Repository\UserRepositoryInterface;
use Poposki\Kernel\Application\Messenger\Command\CommandHandlerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

readonly class PasswordForgotHandler implements CommandHandlerInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private PasswordResetAdapterInterface $passwordResetAdapter,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param PasswordForgotCommand $command
     * @return void
     * @throws ResetPasswordExceptionInterface
     */
    public function __invoke(PasswordForgotCommand $command): void
    {
        if (!$user = $this->userRepository->findOneBy(['email' => $command->getEmail()])) {
            return;
        }

        $token = $this->passwordResetAdapter->generateToken($user);

        $this->eventDispatcher->dispatch(
            new PasswordResetRequestedEvent($command->getEmail(), $token)
        );
    }
}
