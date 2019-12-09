<?php

namespace Kosinski\Amqp\Information;

use Kosinski\Amqp\Contracts\InformationCollector as InformationCollectorContract;
use Kosinski\Amqp\Contracts\InformationCollectorFactory as InformationCollectorFactoryContract;
use Kosinski\Amqp\Exceptions\ClassPropertyAccessorNotFound;

/**
 * Class InformationCollectorFactory
 * @package Kosinski\Amqp\Information
 */
class InformationCollectorFactory implements InformationCollectorFactoryContract
{

    /**
     * @param array $configArray
     *
     * @return InformationCollectorContract
     * @throws ClassPropertyAccessorNotFound
     */
    public function buildInformationCollectorWithAllInformations(array $configArray): InformationCollectorContract
    {
        return (new InformationCollector())->addInformation(
            new AuthenticationInformation($configArray),
            new ConsumerInformation($configArray),
            new ConnectionInformation($configArray),
            new ExchangeInformation($configArray),
            new QueueInformation($configArray)
        );
    }
}
