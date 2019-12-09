<?php

namespace Kosinski\Amqp\Interfaces;

interface Publishable
{
    public function produce(): string;
}
