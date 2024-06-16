<?php

namespace Poposki\Identity\Domain\Factory;

use Poposki\Identity\Domain\Entity\UserInterface;

interface UserFactoryInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return UserInterface
     */
    public function create(string $email, string $password): UserInterface;
}
