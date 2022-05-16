<?php

/**
 * BoolFilterInterface.php
 * Mikro\Repository\Criteria\Filter\Filter\BoolFilterInterface
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
 * Interfaccia filtro buleano
 *
 * Operatori:
 *
 * OPERATOR_EQUAL
 * OPERATOR_NOT_EQUAL
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface BoolFilterInterface extends FilterInterface
{
    /**
     * Recupero valore buleano
     *
     * @return bool
     */
    public function getValue(): bool;
}
