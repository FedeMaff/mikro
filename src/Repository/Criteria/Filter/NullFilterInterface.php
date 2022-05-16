<?php

/**
 * NullFilterInterface.php
 * Mikro\Repository\Criteria\Filter\Filter\NullFilterInterface
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
 * Interfaccia filtro null
 *
 * Operatori:
 *
 * OPERATOR_IS_NULL
 * OPERATOR_IS_NOT_NULL
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface NullFilterInterface extends FilterInterface
{
}
