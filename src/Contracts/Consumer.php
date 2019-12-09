<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\AmqpConnection;
use Kosinski\Amqp\Events\MessageAcknowledgeEvent;
use Kosinski\Amqp\Events\MessageRejectEvent;
use Kosinski\Amqp\Exceptions\ConsumerInvalidConnectionException;
use Kosinski\Amqp\Exceptions\ConsumerInvalidMessageException;
use Kosinski\Amqp\Interfaces\Consumable;
use PhpAmqpLib\Message\AMQPMessage;

abstract class Consumer extends AmqpSupport implements Consumable
{
    /**
     * @var AMQPMessage
     */
    protected AMQPMessage $message;

    /**
     * @var AmqpConnection
     */
    protected AmqpConnection $connection;

    abstract public function consume(): void;

    public function acknowledge(): void
    {
        $this->message->delivery_info['channel']->basic_ack($this->message->delivery_info['delivery_tag']);

        event(new MessageAcknowledgeEvent($this));
    }

    /**
     * @param bool $requeue
     *
     * @throws ConsumerInvalidConnectionException
     * @throws ConsumerInvalidMessageException
     */
    public function reject($requeue = false): void
    {
        $this->checkProperties();

        $this->message->delivery_info['channel']->basic_reject($this->message->delivery_info['delivery_tag'], $requeue);

        event(new MessageRejectEvent($this));
    }

    /**
     * @throws ConsumerInvalidConnectionException
     * @throws ConsumerInvalidMessageException
     */
    private function checkProperties() {
        if(!$this->message instanceof AMQPMessage) {
            throw new ConsumerInvalidMessageException;
        }

        if(!$this->connection instanceof AmqpConnection) throw new ConsumerInvalidConnectionException();
    }

    public function setMessage(AMQPMessage $message): Consumer {
        $this->message = $message;

        return $this;
    }

    public function setConnection(AmqpConnection $connection): Consumer {
        $this->connection = $connection;

        return $this;
    }

}
