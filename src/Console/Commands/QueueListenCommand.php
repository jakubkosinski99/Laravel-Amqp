<?php

namespace Kosinski\Amqp\Console\Commands;

use Illuminate\Console\Command;
use Kosinski\Amqp\Events\MessageAcknowledgeEvent;
use Kosinski\Amqp\Events\MessageConsumingEvent;
use Kosinski\Amqp\Events\MessageRejectEvent;
use Kosinski\Amqp\Facades\Amqp;
use PhpAmqpLib\Exception\AMQPHeartbeatMissedException;

class QueueListenCommand extends Command
{

    protected $signature = 'amqp:listen {queue=default}';

    public function handle()
    {
        $this->info('Listening for messages in ' . $this->argument('queue') . ' queue.');
        $this->listenForEvents();

        while (true) {
            try {
                Amqp::consume(
                    $this->argument('queue'), [
                    'connection' => [
                        'persistent' => true,
                    ],
                    'consumer' => [
                        'autoStopConsume' => false,
                    ],
                ], true);
            } catch (\Exception $exception) {
                if($exception instanceof AMQPHeartbeatMissedException) {
                    continue;
                }

                $this->error($exception->getMessage());
            }
        }
    }

    private function listenForEvents()
    {
        $this->laravel['events']->listen(
            MessageAcknowledgeEvent::class, function($event) {
            $this->info('Consumed');
        });

        $this->laravel['events']->listen(
            MessageRejectEvent::class, function($event) {
            $this->error('Rejected');
        });
    }

}
