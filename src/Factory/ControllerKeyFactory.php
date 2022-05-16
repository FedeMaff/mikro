<?php

/**
 * ControllerKeyFactory.php
 * Mikro\Factory\ControllerKeyFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\ControllerKey\ControllerKeyInterface;
use Mikro\ControllerKey\HttpKey;
use Mikro\ControllerKey\AmqpKey;
use Mikro\ControllerKey\CliKey;

/**
 * Factory di generazione istanze ControllerKey
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class ControllerKeyFactory
{
    /**
     * Generazione istanza chiave controller
     *
     * @param string $className Nome istanza ControllerInterface
     *
     * @return ControllerKeyInterface
     */
    public static function create(string $className): ControllerKeyInterface
    {
        $interfaces = class_implements($className);

        switch ($interfaces) {
            case (in_array('Mikro\Controller\CliControllerInterface', $interfaces)):
                return new CliKey($className);
            break;
            case (in_array('Mikro\Controller\HttpControllerInterface', $interfaces)):
                return new HttpKey($className);
            break;
            case (in_array('Mikro\Controller\AmqpControllerInterface', $interfaces)):
                return new AmqpKey($className);
            break;
        }
    }
}
