<?php

/**
 * ControllerKeyInterface.php
 * Mikro\ControllerKey\ControllerKeyInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\ControllerKey;

/**
 * Interfaccia generica identificativo chiave controller
 * Si intende generare una Factry che data una RequestInterface
 * sia in grado di creare l'apposita istanza controller. Per permettere
 * al sistema di determinare il giusto controller è necessario adottare
 * un riferimento che possa essere adottato nei 3 attuali scenari:
 * http, amqp e cli. Si battezza quindi questa ControllerKey, interfaccia
 * che fungerà da fulcro della Factory dei controller.
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ControllerKeyInterface
{
}
