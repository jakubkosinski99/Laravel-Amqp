<?php

namespace Kosinski\Amqp;

use Kosinski\Amqp\Contracts\Consumer;
use PhpAmqpLib\Message\AMQPMessage;

class TestConsumer extends Consumer
{

    public function consume(): void
    {

        $this->acknowledge();
    }
}
