<?php

/**
 * NullFilter.php
 * Mikro\Repository\Criteria\Filter\Filter\NullFilter
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterAbstract;
use Mikro\Repository\Criteria\Filter\NullFilterInterface;

/**
 * Implementazione concreta filtro null
 *
 * Operatori:
 *
 * OPERATOR_IS_NULL
 * OPERATOR_IS_NOT_NULL
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class NullFilter extends FilterAbstract implements NullFilterInterface
{
}
