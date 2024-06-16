<?php

namespace Poposki\Kernel\Application\Messenger;

use Symfony\Component\Messenger\Exception\HandlerFailedException;

abstract class AbstractMessageBus implements MessageBusInterface
{
    /**
     * {@inheritDoc}
     */
    public function throwException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }

        throw $exception;
    }
}
