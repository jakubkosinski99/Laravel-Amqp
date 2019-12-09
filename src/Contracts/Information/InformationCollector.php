<?php

namespace Kosinski\Amqp\Contracts;

use Kosinski\Amqp\Support\InformationAccessors;

interface InformationCollector
{
    public function getProperty(InformationAccessors $informationAccessors, string $key, string $default = null);

    public function addInformation(Information ...$information): InformationCollector;

    public function setProperty(InformationAccessors $informationAccessors, string $key, $value);
}
