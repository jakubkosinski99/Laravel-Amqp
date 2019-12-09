<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Annotations\AmqpProperty;
use Kosinski\Amqp\Annotations\PropertyAccessor;

/**
 * Class ConsumerInformation
 * @package Kosinski\Amqp\Second\Contracts
 *
 * @PropertyAccessor(name="consumer")
 */
abstract class ConsumerInformation extends Information
{

    /**
     * @AmqpProperty(name="tag")
     */
    protected $tag;

    /**
     * @AmqpProperty(name="noLocal")
     */
    protected $noLocal;

    /**
     * @AmqpProperty(name="noAck")
     */
    protected $noAck;

    /**
     * @AmqpProperty(name="exclusive")
     */
    protected $exclusive;

    /**
     * @AmqpProperty(name="autoStopConsume")
     */
    protected $autoStopConsume;

    /**
     * @AmqpProperty(name="noWait")
     */
    protected $noWait;

    public function getPropertyAccessor(): string
    {
        return 'consumer';
    }
}
