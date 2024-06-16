<?php

namespace Poposki\Identity\Infrastructure\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Poposki\Identity\Domain\Entity\User;
use Poposki\Identity\Domain\Entity\UserInterface;
use Poposki\Identity\Domain\Repository\UserRepositoryInterface;
use Poposki\Kernel\Infrastructure\Doctrine\Repository\AbstractRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface, PasswordUpgraderInterface
{
    public const string TABLE_ALIAS = 'u';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * {@inheritDoc}
     */
    public function add(UserInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function remove(UserInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof UserInterface) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
