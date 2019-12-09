<?php

namespace Kosinski\Amqp\Information;

use Kosinski\Amqp\Annotations\PropertyAccessor;
use Kosinski\Amqp\Contracts\AuthenticationInformation as AuthenticationInformationContract;

/**
 * Class AuthenticationInformation
 * @package Kosinski\Amqp\Information
 *
 * @PropertyAccessor(name="authentication")
 */
class AuthenticationInformation extends AuthenticationInformationContract
{

}
