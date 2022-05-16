<?php

/**
 * AmqpController.php
 * Mikro\Controller\AmqpController
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Controller;

use Mikro\Controller\ControllerAbstract;
use Mikro\Controller\AmqpControllerInterface;

/**
 * Implementazione astratta controller AMQP
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class AmqpController extends ControllerAbstract implements AmqpControllerInterface
{
    /**
     * Nome evento di riferimento
     *
     * @var string $eventName Nome evento
     */
    protected static string $eventName = '';

    /**
     * Recupero nome evento di riferimento
     *
     * @return string
     */
    public static function getEventName(): string
    {
        return static::$eventName;
    }

    /**
     * Esecuzione controller e logiche di business implementate
     *
     * @return void
     */
    public function run(): void
    {
    }
}
