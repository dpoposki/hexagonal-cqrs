<?php

namespace Poposki\Identity\Domain\Factory;

use Poposki\Identity\Domain\Entity\User;
use Poposki\Identity\Domain\Entity\UserInterface;

final class UserFactory implements UserFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(string $email, string $password): UserInterface
    {
        return (new User())
            ->setEmail($email)
            ->setPassword($password)
            ->setUsername($this->generateUsername($email))
            ->setName($this->generateName($email));
    }

    /**
     * TODO: Generate a username based on the email the user entered
     */
    private function generateUsername(string $email): string
    {
        return explode('@', $email)[0];
    }

    /**
     * TODO: Generate a name based on the email the user entered
     */
    private function generateName(string $email): string
    {
        return explode('@', $email)[0];
    }
}
