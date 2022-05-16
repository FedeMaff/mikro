<?php

/**
 * ArrayFilterInterface.php
 * Mikro\Repository\Criteria\Filter\Filter\ArrayFilterInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterInterface;

/**
 * Interfaccia filtro array
 *
 * Operatori:
 *
 * OPERATOR_IN
 * OPERATOR_NOT_IN
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ArrayFilterInterface extends FilterInterface
{
    /**
     * Recupero valore array
     *
     * @return array
     */
    public function getValue(): array;
}
