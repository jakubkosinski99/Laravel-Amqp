<?php

namespace Kosinski\Amqp\Events;

use Kosinski\Amqp\Contracts\AmqpSupport;
use Kosinski\Amqp\Contracts\Consumer;

class MessageRejectEvent
{
    /**
     * @var AmqpSupport
     */
    private AmqpSupport $consumer;

    public function __construct(AmqpSupport $consumer)
    {
        $this->consumer = $consumer;
    }

    public function getConsumer() {
        return $this->consumer;
    }
}
