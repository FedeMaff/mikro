<?php

/**
 * DateTimeFilterInterface.php
 * Mikro\Repository\Criteria\Filter\Filter\DateTimeFilterInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterInterface;
use DateTime;

/**
 * Interfaccia filtro data ora
 *
 * Operatori:
 *
 * OPERATOR_EQUAL
 * OPERATOR_NOT_EQUAL
 * OPERATOR_LESS_THAN
 * OPERATOR_LESS_THAN_OR_EQUAL
 * OPERATOR_GREATER_THAN
 * OPERATOR_GREATER_THAN_OR_EQUAL
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface DateTimeFilterInterface extends FilterInterface
{
    /**
     * Recupero valore istanza DateTime ( data ora )
     *
     * @return DateTime
     */
    public function getValue(): DateTime;
}
