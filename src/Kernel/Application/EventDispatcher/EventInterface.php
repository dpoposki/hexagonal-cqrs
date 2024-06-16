<?php

namespace Poposki\Kernel\Application\EventDispatcher;

interface EventInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function occurredOn(): \DateTimeInterface;
}
