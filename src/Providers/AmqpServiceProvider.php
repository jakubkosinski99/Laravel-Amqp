<?php

namespace Kosinski\Amqp\Providers;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider;
use Kosinski\Amqp\Amqp;
use Kosinski\Amqp\Annotations\AmqpProperty;
use Kosinski\Amqp\Annotations\PropertyAccessor;
use Kosinski\Amqp\Console\Commands\QueueListenCommand;

class AmqpServiceProvider extends ServiceProvider
{

    public array $singletons = [
        'amqp' => Amqp::class,
    ];

    public function boot() {
        $this->mergeConfigFrom(__DIR__ . '/../../config/amqp.php', 'amqp');

        AnnotationRegistry::registerFile(
            (new \ReflectionClass(AmqpProperty::class))->getFileName()
        );
        AnnotationRegistry::registerFile(
                (new \ReflectionClass(PropertyAccessor::class))->getFileName()
            );

        $this->commands([
            QueueListenCommand::class
        ]);
    }
}
