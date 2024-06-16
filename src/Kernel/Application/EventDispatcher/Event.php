<?php

namespace Poposki\Kernel\Application\EventDispatcher;

class Event extends \Symfony\Contracts\EventDispatcher\Event implements EventInterface
{
    /**
     * {@inheritDoc}
     */
    public function occurredOn(): \DateTimeInterface
    {
        return new \DateTimeImmutable();
    }
}
