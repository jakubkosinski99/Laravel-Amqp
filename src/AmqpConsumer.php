<?php

namespace Kosinski\Amqp;

use Exception;
use Kosinski\Amqp\Contracts\AmqpSupport;
use Kosinski\Amqp\Contracts\Consumer;
use Kosinski\Amqp\Events\MessageConsumingEvent;
use Kosinski\Amqp\Exceptions\ConsumerShouldStopException;
use Kosinski\Amqp\Support\InformationAccessors;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use Kosinski\Amqp\Exceptions\ClassPropertyAccessorNotFound;

/**
 * Class AmqpConsumer
 * @package Kosinski\Amqp
 */
class AmqpConsumer extends AmqpConnection
{
    /**
     * AmqpConsumer constructor.
     *
     * @param Consumer $consumer
     * @param array $customProperties
     *
     * @throws ClassPropertyAccessorNotFound
     */
    public function __construct(Consumer $consumer, array $customProperties = [])
    {
        parent::__construct($consumer, $customProperties);
    }

    /**
     * @return AmqpConnection
     * @throws Exception
     */
    public function consume(): AmqpConnection
    {
        try {


            if ($this->queueSize() === 0 && !$this->getInformationCollector()->getProperty(InformationAccessors::CONNECTION(), 'persistent')) {
                throw new ConsumerShouldStopException();
            }

            $this->getChannel()->basic_consume(
                $this->getAmqpSupport()->getQueueName(),
                $this->getInformationCollector()->getProperty(InformationAccessors::CONSUMER(), 'tag'),
                $this->getInformationCollector()->getProperty(InformationAccessors::CONSUMER(), 'noLocal'),
                $this->getInformationCollector()->getProperty(InformationAccessors::CONSUMER(), 'noAck'),
                $this->getInformationCollector()->getProperty(InformationAccessors::CONSUMER(), 'exclusive'),
                $this->getInformationCollector()->getProperty(InformationAccessors::CONSUMER(), 'noWait'),
                $this->consumeCallback()
            );

            while (count($this->getChannel()->callbacks) || !$this->getInformationCollector()->getProperty(InformationAccessors::CONSUMER(), 'autoStopConsume')) {
                $this->getChannel()->wait(
                    null,
                    false,
                    $this->getInformationCollector()->getProperty(InformationAccessors::CONNECTION(), 'timeout', 0));
            }
        } catch (AMQPTimeoutException | ConsumerShouldStopException $exception) {
            return $this;
        } catch (Exception $exception) {
            throw $exception;
        }

        return $this;
    }

    private function consumeCallback()
    {
        $connection = $this;

        return function($message) use ($connection) {
            $connection->getAmqpSupport()->setMessage($message)->setConnection($connection);

            event(new MessageConsumingEvent($connection->getAmqpSupport()));

            $connection->getAmqpSupport()->consume();
        };
    }

}
