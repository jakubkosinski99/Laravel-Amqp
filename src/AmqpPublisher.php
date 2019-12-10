<?php

namespace Kosinski\Amqp;

use Kosinski\Amqp\Contracts\Producer;
use Kosinski\Amqp\Exceptions\ClassPropertyAccessorNotFound;
use Kosinski\Amqp\Support\InformationAccessors;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class AmqpPublisher
 * @package Kosinski\Amqp
 */
class AmqpPublisher extends AmqpConnection
{
    /**
     * AmqpPublisher constructor.
     *
     * @param Producer $producer
     * @param array $customProperties
     *
     * @throws ClassPropertyAccessorNotFound
     */
    public function __construct(Producer $producer, array $customProperties = [])
    {
        parent::__construct($producer, $customProperties);
    }

    /**
     * @return AmqpConnection
     */
    public function publish(): AmqpConnection
    {
        $this->getChannel()->basic_publish(
            new AMQPMessage($this->getAmqpSupport()->produce(), ['content_type' => 'text/plain', 'delivery_mode' => 2]),
                $this->getInformationCollector()->getProperty(InformationAccessors::EXCHANGE(), 'exchange'),
                $this->getAmqpSupport()->getRouting()
            );

        return $this;
    }
}
