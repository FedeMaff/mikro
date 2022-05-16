<?php

/**
 * FiltersGroupFactory.php
 * Mikro\Factory\FiltersGroupFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Repository\Criteria\FiltersGroup\FiltersGroupInterface;
use Mikro\Repository\Criteria\FiltersGroup\AndGroup;
use Mikro\Repository\Criteria\FiltersGroup\OrGroup;
use Mikro\Repository\Criteria\Filter\FilterInterface;

/**
 * Factory di generazione istanze Gruppo di filtri
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class FiltersGroupFactory
{
    /**
     * Generazione istanza controller
     *
     * @param string $operator Operatore
     * @param FilterInterface[] $filters Elenco di istanze di filtro
     * @param FiltersGroupInterface[] $groups Elenco di istanze gruppo filtri
     *
     * @return FiltersGroupInterface
     */
    public static function create(string $operator, array $filters = [], array $groups = []): FiltersGroupInterface
    {
        return ($operator == OPERATOR_OR) ? new OrGroup($filters, $groups) : new AndGroup($filters, $groups);
    }
}
