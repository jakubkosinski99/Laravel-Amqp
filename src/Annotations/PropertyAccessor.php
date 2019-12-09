<?php

namespace Kosinski\Amqp\Annotations;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class PropertyAccessor
 * @package Kosinski\Amqp\Annotations
 * @Annotation
 * @Target({"CLASS"})
 */
class PropertyAccessor
{
    public $name;
}
