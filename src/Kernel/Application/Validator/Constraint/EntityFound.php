<?php

namespace Poposki\Kernel\Application\Validator\Constraint;

use Poposki\Kernel\Application\Validator\Constraint;
use Poposki\Kernel\Application\Validator\EntityFoundValidator;
use Symfony\Component\Validator\Attribute\HasNamedArguments;

#[\Attribute]
final class EntityFound extends Constraint
{
    public const string ENTITY_NOT_FOUND_ERROR = '205a43fa-3a7c-48e6-9b51-9656e58b3744';

    protected const array ERROR_NAMES = [
        self::ENTITY_NOT_FOUND_ERROR => 'ENTITY_NOT_FOUND_ERROR',
    ];

    public string $message = 'This entity is not found.';

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
        return EntityFoundValidator::class;
    }
}
