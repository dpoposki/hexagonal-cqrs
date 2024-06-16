<?php

namespace Poposki\Identity\Infrastructure\Doctrine\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Poposki\Identity\Domain\Entity\UserPasswordReset;
use Poposki\Kernel\Infrastructure\Doctrine\Repository\AbstractRepository;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

/**
 * @method UserPasswordReset|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPasswordReset|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPasswordReset[]    findAll()
 * @method UserPasswordReset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPasswordResetRepository extends AbstractRepository implements ResetPasswordRequestRepositoryInterface
{
    use ResetPasswordRequestRepositoryTrait;

    public const string TABLE_ALIAS = 'upr';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPasswordReset::class);
    }

    /**
     * {@inheritDoc}
     */
    public function createResetPasswordRequest(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken): ResetPasswordRequestInterface
    {
        return new UserPasswordReset($user, $expiresAt, $selector, $hashedToken);
    }
}
