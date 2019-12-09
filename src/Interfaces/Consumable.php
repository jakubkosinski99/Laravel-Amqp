<?php

namespace Kosinski\Amqp\Interfaces;

/**
 * Interface Consumable
 * @package Kosinski\Amqp\Interfaces
 */
interface Consumable
{
    public function consume(): void;

    public function acknowledge(): void;

    public function reject(): void;
}
