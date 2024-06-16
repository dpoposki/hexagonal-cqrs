<?php

namespace Poposki\Identity\Domain\Repository;

use Poposki\Identity\Domain\Entity\UserInterface;

interface UserRepositoryInterface
{
    /**
     * @param UserInterface $entity
     * @param bool $flush
     *
     * @return void
     */
    public function add(UserInterface $entity, bool $flush = false): void;

    /**
     * @param UserInterface $entity
     * @param bool $flush
     *
     * @return void
     */
    public function remove(UserInterface $entity, bool $flush = false): void;
}
