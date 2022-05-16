<?php

/**
 * ControllerAbstract.php
 * Mikro\Controller\ControllerAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Controller;

use Mikro\Controller\ControllerInterface;
use Mikro\Request\RequestInterface;

/**
 * Interfaccia generica controller
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class ControllerAbstract implements ControllerInterface
{
    /**
     * Istanza richiesta
     *
     * @var ?RequestInterface $request istanza RequestInterface
     */
    protected ?RequestInterface $request = null;

    /**
     * Assegnazione richiesta
     *
     * @var RequestInterface $request Istanza RequestInterface
     */
    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }
}
