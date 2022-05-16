<?php

/**
 * StringFilterInterface.php
 * Mikro\Repository\Criteria\Filter\Filter\StringFilterInterface
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
 * Interfaccia filtro stringa
 *
 * Operatori:
 *
 * OPERATOR_EQUAL
 * OPERATOR_NOT_EQUAL
 * OPERATOR_STARTS_WITH
 * OPERATOR_ENDS_WITH
 * OPERATOR_CONTAINS
 * OPERATOR_NOT_CONTAINS
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface StringFilterInterface extends FilterInterface
{
    /**
     * Recupero valore stringa
     *
     * @return string
     */
    public function getValue(): string;
}
