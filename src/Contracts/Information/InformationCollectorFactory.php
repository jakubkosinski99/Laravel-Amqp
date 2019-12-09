<?php

namespace Kosinski\Amqp\Contracts;

interface InformationCollectorFactory
{
    public function buildInformationCollectorWithAllInformations(array $configArray): InformationCollector;
}
