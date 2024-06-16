<?php

namespace Poposki\Kernel\Application\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Poposki\Kernel\Application\Validator\Constraint\EntityFound;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class EntityFoundValidator extends ConstraintValidator
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
        if (!$constraint instanceof EntityFound) {
            throw new UnexpectedTypeException($constraint, EntityFound::class);
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

        if ($entity === null) {
            $this->context->buildViolation($constraint->message)
                ->setCode(EntityFound::ENTITY_NOT_FOUND_ERROR)
                ->addViolation();
        }
    }
}
