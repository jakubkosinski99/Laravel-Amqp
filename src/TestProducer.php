<?php

namespace Kosinski\Amqp;

use Kosinski\Amqp\Contracts\Producer;

class TestProducer extends Producer
{
    protected string $queueName = 'hej';

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function produce(): string
    {
        return $this->name;
    }
}
