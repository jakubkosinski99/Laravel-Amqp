<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Annotations\AmqpProperty;
use Kosinski\Amqp\Annotations\PropertyAccessor;

/**
 * Class QueueInformation
 * @package Kosinski\Amqp\Second\Contracts
 *
 * @PropertyAccessor(name="queue")
 */
abstract class QueueInformation extends Information
{
    /**
     * @AmqpProperty(name="forceDeclare", default=false)
     */
    protected bool $forceDeclare;

    /**
     * @AmqpProperty(name="passive", default=false)
     */
    protected bool $passive;

    /**
     * @AmqpProperty(name="durable", default=true)
     */
    protected bool $durable;

    /**
     * @AmqpProperty(name="exclusive", default=false)
     */
    protected bool $exclusive;

    /**
     * @AmqpProperty(name="autoDelete", default=false)
     */
    protected bool $autoDelete;

    /**
     * @AmqpProperty(name="noWait", default=false)
     */
    protected bool $noWait;

    /**
     * 'x-ha-policy' => {'S', 'all'}
     * @AmqpProperty(name="properties", default={"x-ha-policy" = {"S", "all"}})
     */
    protected array $properties;
}
