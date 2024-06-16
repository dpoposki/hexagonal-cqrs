<?php

namespace Poposki\Identity\Application\Messenger\Command\Handler;

use Poposki\Identity\Application\Messenger\Command\UserRegisterCommand;
use Poposki\Identity\Domain\Factory\UserFactoryInterface;
use Poposki\Identity\Domain\Repository\UserRepositoryInterface;
use Poposki\Kernel\Application\Messenger\Command\CommandHandlerInterface;

readonly class UserRegisterHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserFactoryInterface $userFactory,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param UserRegisterCommand $command
     * @return void
     */
    public function __invoke(UserRegisterCommand $command): void
    {
        $user = $this->userFactory->create(
            $command->getEmail(),
            $command->getPassword()
        );

        $this->userRepository->add($user);
    }
}
