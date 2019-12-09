<?php

namespace Kosinski\Amqp\Information;

use Kosinski\Amqp\Annotations\PropertyAccessor;
use Kosinski\Amqp\Contracts\ConnectionInformation as ConnectionInformationContract;

/**
 * Class ConnectionInformation
 * @package Kosinski\Amqp\Information
 *
 * @PropertyAccessor(name="connection")
 */
class ConnectionInformation extends ConnectionInformationContract
{

}
