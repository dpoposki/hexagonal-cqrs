<?php

namespace Poposki\Kernel\Application\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Poposki\Kernel\Application\Validator\Constraint\EntityNotFound;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class EntityNotFoundValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     *
     * @return void
     */
    public function validate($value, \Symfony\Component\Validator\Constraint $constraint): void
    {
        if (!$constraint instanceof EntityNotFound) {
            throw new UnexpectedTypeException($constraint, EntityNotFound::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_int($value) && !is_string($value)) {
            throw new UnexpectedValueException($value, 'int|string');
        }

        $criteria = array_map(function ($v) use ($value) {
            return $v == Constraint::VALUE ? $value : $v;
        }, $constraint->payload);

        $entity = $this->entityManager->getRepository($constraint->entity)->findOneBy($criteria);

        if ($entity !== null) {
            $this->context->buildViolation($constraint->message)
                ->setCode(EntityNotFound::ENTITY_IS_FOUND_ERROR)
                ->addViolation();
        }
    }
}
