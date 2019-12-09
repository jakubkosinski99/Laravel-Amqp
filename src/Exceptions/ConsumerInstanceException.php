<?php

namespace Kosinski\Amqp\Exceptions;

use Exception;
use Kosinski\Amqp\Contracts\Consumer;
use Throwable;

/**
 * Class ConsumerInstanceException
 * @package Kosinski\Amqp\Exceptions
 */
class ConsumerInstanceException extends Exception
{
    /**
     * ConsumerInstanceException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message . " should be instance of " . Consumer::class, $code, $previous);
    }

}
