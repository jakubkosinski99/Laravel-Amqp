<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Interfaces\Publishable;

abstract class Producer extends AmqpSupport implements Publishable
{
    public function onQueue(string $queueName): Producer
    {
        return $this;
    }



}
