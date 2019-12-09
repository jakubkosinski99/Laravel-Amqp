<?php

namespace Kosinski\Amqp\Information;

use Kosinski\Amqp\Annotations\PropertyAccessor;
use Kosinski\Amqp\Contracts\QueueInformation as QueueInformationContract;

/**
 * Class QueueInformation
 * @package Kosinski\Amqp\Information
 *
 * @PropertyAccessor(name="queue")
 */
class QueueInformation extends QueueInformationContract
{

}
