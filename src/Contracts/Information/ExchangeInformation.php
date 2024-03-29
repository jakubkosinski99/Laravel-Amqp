<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Annotations\AmqpProperty;
use Kosinski\Amqp\Annotations\PropertyAccessor;

/**
 * Class ExchangeInformation
 * @package Kosinski\Amqp\Second\Contracts
 *
 * @PropertyAccessor(name="exchange")
 */
abstract class ExchangeInformation extends Information
{

    /**
     * @AmqpProperty(name="exchange", default="amq.topic")
     */
    protected string $exchange;

    /**
     * @AmqpProperty(name="type", default="topic")
     */
    protected string $type;

    /**
     * @AmqpProperty(name="passive", default=false)
     */
    protected bool $passive;

    /**
     * @AmqpProperty(name="durable", default=true)
     */
    protected bool $durable;

    /**
     * @AmqpProperty(name="autoDelete", default=false)
     */
    protected bool $autoDelete;

    /**
     * @AmqpProperty(name="internal", default=false)
     */
    protected bool $internal;

    /**
     * @AmqpProperty(name="noWait", default=false)
     */
    protected bool $noWait;

    /**
     * @AmqpProperty(name="properties", default={})
     */
    protected array $properties;

    public function getPropertyAccessor(): string
    {
        return 'exchange';
    }
}
