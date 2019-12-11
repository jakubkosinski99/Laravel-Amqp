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
     * @throws ConsumerInvalidMessageException
     */
    private function checkProperties() {
        if(!$this->message instanceof AMQPMessage) {
            throw new ConsumerInvalidMessageException;
        }
    }

    public function setMessage(AMQPMessage $message): Consumer {
        $this->message = $message;

        return $this;
    }

}
