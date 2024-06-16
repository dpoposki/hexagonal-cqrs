<?php

namespace Poposki\Identity\Domain\Entity;

use Poposki\Kernel\Domain\Entity\EntityInterface;

interface UserInterface extends EntityInterface, \Symfony\Component\Security\Core\User\UserInterface
{
}
