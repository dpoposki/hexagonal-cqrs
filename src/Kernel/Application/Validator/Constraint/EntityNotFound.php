<?php

namespace Poposki\Kernel\Application\Validator\Constraint;

use Poposki\Kernel\Application\Validator\Constraint;
use Poposki\Kernel\Application\Validator\EntityNotFoundValidator;
use Symfony\Component\Validator\Attribute\HasNamedArguments;

#[\Attribute]
final class EntityNotFound extends Constraint
{
    public const string ENTITY_IS_FOUND_ERROR = '9a5f8093-2218-4b1d-8bab-a3b29fef8fe6';

    protected const array ERROR_NAMES = [
        self::ENTITY_IS_FOUND_ERROR => 'ENTITY_IS_FOUND_ERROR',
    ];

    public string $message = 'This entity is found.';

    #[HasNamedArguments]
    public function __construct(public string $entity, array $groups = null, mixed $payload = null, ?string $message = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy(): string
    {
        return EntityNotFoundValidator::class;
    }
}
