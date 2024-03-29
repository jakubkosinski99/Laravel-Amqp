<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Annotations\AmqpProperty;
use Kosinski\Amqp\Annotations\PropertyAccessor;

/**
 * Class ConnectionInformation
 * @package Kosinski\Amqp\Second\Contracts
 *
 * @PropertyAccessor(name="connection")
 */
abstract class ConnectionInformation extends Information
{
    /**
     * @AmqpProperty(name="host", default="localhost")
     */
    protected string $host;

    /**
     * @AmqpProperty(name="port", default="5672")
     */
    protected int $port;

    /**
     * @AmqpProperty(name="vhost", default="/")
     */
    protected string $vhost;

    /**
     * @AmqpProperty(name="options", default={})
     */
    protected array $options;

    /**
     * @AmqpProperty(name="ssl", default={})
     */
    protected array $ssl;

    /**
     * @AmqpProperty(name="timeout", default=5)
     */
    protected int $timeout;

    /**
     * @AmqpProperty(name="persistent", default=false)
     */
    protected bool $persistent;

    public function getPropertyAccessor(): string
    {
        return 'connection';
    }
}
