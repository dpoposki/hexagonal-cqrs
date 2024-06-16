<?php

namespace Poposki\Kernel\Application\Messenger\Command;

use Poposki\Kernel\Application\Messenger\AbstractMessageBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus extends AbstractMessageBus implements CommandBusInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function handle(CommandInterface $command): Envelope
    {
        try {
            return $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $exception) {
            $this->throwException($exception);
        }
    }
}
