<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Annotations\AmqpProperty;
use Kosinski\Amqp\Annotations\PropertyAccessor;

/**
 * Class AuthenticationInformation
 * @package Kosinski\Amqp\Second\Contracts
 *
 * @PropertyAccessor(name="authentication")
 */
abstract class AuthenticationInformation extends Information
{
    /**
     * @AmqpProperty(name="username", default="guest")
     */
    protected string $username;

    /**
     * @AmqpProperty(name="password", default="guest")
     */
    protected string $password;

}
