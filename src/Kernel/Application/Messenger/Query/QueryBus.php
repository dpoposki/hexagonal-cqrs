<?php

namespace Poposki\Kernel\Application\Messenger\Query;

use Poposki\Kernel\Application\Messenger\AbstractMessageBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class QueryBus extends AbstractMessageBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $messageBus
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function ask(QueryInterface $query): mixed
    {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $exception) {
            $this->throwException($exception);
        }
    }
}
