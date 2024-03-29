<?php

namespace Kosinski\Amqp;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Config;
use Kosinski\Amqp\Contracts\Consumer;
use Kosinski\Amqp\Contracts\Producer;
use Kosinski\Amqp\Exceptions\ClassPropertyAccessorNotFound;
use Kosinski\Amqp\Exceptions\ConsumerInstanceException;
use Kosinski\Amqp\Exceptions\QueueDefaultConsumerException;

/**
 * Class Amqp
 * @package Kosinski\Amqp
 */
class Amqp
{

    /**
     * @param Producer $producer
     * @param array $customProperties
     *
     * @throws ClassPropertyAccessorNotFound
     */
    public function publish(Producer $producer, array $customProperties = []): void {
        (new AmqpPublisher($producer, $customProperties))->publish()->closeCurrentConnection();
    }

    /**
     * @param string $consumerClass
     * @param array $customProperties
     *
     * @param bool $queue
     *
     * @throws BindingResolutionException
     * @throws ClassPropertyAccessorNotFound
     * @throws ConsumerInstanceException
     * @throws QueueDefaultConsumerException
     */
    public function consume(string $consumerClass, array $customProperties = [], bool $queue = false): void {
        if($queue) {
            $queue = $consumerClass;
            $consumerClass = Config::get('amqp.consumers.'.$queue);

            if(!$consumerClass) throw new QueueDefaultConsumerException($queue);
        }

        $consumer = app()->make($consumerClass);

        if(!$consumer instanceof Consumer) {
            throw new ConsumerInstanceException($consumerClass);
        }

        if($queue) $consumer->onQueue($queue);

        (new AmqpConsumer($consumer, $customProperties))->consume()->closeCurrentConnection();
    }
}
