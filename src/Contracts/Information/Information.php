<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Interfaces\Propertiable;
use Kosinski\Amqp\Traits\hasAmqpProperties;

abstract class Information implements Propertiable
{
    use hasAmqpProperties;
}
