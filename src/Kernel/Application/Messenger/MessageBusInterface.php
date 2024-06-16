<?php

namespace Poposki\Kernel\Application\Messenger;

use Symfony\Component\Messenger\Exception\HandlerFailedException;

interface MessageBusInterface
{
    /**
     * @param HandlerFailedException $exception
     * @return void
     * @throws \Throwable
     */
    public function throwException(HandlerFailedException $exception): void;
}
