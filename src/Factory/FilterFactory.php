<?php

/**
 * FilterFactory.php
 * Mikro\Factory\FilterFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Repository\Criteria\Filter\FilterInterface;
use Mikro\Repository\Criteria\Filter\ArrayFilter;
use Mikro\Repository\Criteria\Filter\BoolFilter;
use Mikro\Repository\Criteria\Filter\DateFilter;
use Mikro\Repository\Criteria\Filter\DateTimeFilter;
use Mikro\Repository\Criteria\Filter\FloatFilter;
use Mikro\Repository\Criteria\Filter\IntFilter;
use Mikro\Repository\Criteria\Filter\NullFilter;
use Mikro\Repository\Criteria\Filter\StringFilter;
use DateTime;

/**
 * Factory di generazione istanze Filtro
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class FilterFactory
{
    /**
     * Generazione istanza controller
     *
     * @param string $field Proprietà oggetto di filtro
     * @param string $operator Operatore
     * @param mixed $value Valore filtro
     *
     * @return ?FilterInterface
     */
    public static function create(string $field, string $operator, $value = null): ?FilterInterface
    {
        if (
            in_array($operator, [
            OPERATOR_IS_NULL,
            OPERATOR_IS_NOT_NULL
            ])
        ) {
            return new NullFilter($field, $operator);
        }

        switch (true) {
            case is_array($value):
                if (
                    in_array($operator, [
                    OPERATOR_IN,
                    OPERATOR_NOT_IN
                    ])
                ) {
                    return new ArrayFilter($field, $operator, $value);
                }
                break;
            case is_bool($value):
                if (
                    in_array($operator, [
                    OPERATOR_EQUAL,
                    OPERATOR_NOT_EQUAL
                    ])
                ) {
                    return new BoolFilter($field, $operator, $value);
                }
                break;
            case ($value instanceof DateTime):
                if (
                    in_array($operator, [
                    OPERATOR_EQUAL,
                    OPERATOR_NOT_EQUAL,
                    OPERATOR_LESS_THAN,
                    OPERATOR_LESS_THAN_OR_EQUAL,
                    OPERATOR_GREATER_THAN,
                    OPERATOR_GREATER_THAN_OR_EQUAL
                    ])
                ) {
                    return new DateTimeFilter($field, $operator, $value);
                }
                break;
            case is_float($value):
                if (
                    in_array($operator, [
                    OPERATOR_EQUAL,
                    OPERATOR_NOT_EQUAL,
                    OPERATOR_LESS_THAN,
                    OPERATOR_LESS_THAN_OR_EQUAL,
                    OPERATOR_GREATER_THAN,
                    OPERATOR_GREATER_THAN_OR_EQUAL])
                ) {
                    return new FloatFilter($field, $operator, $value);
                }
                break;
            case is_int($value):
                if (
                    in_array($operator, [
                    OPERATOR_EQUAL,
                    OPERATOR_NOT_EQUAL,
                    OPERATOR_LESS_THAN,
                    OPERATOR_LESS_THAN_OR_EQUAL,
                    OPERATOR_GREATER_THAN,
                    OPERATOR_GREATER_THAN_OR_EQUAL
                    ])
                ) {
                    return new IntFilter($field, $operator, $value);
                }
                break;
            case is_string($value):
                if (
                    in_array($operator, [OPERATOR_EQUAL,
                    OPERATOR_NOT_EQUAL,
                    OPERATOR_STARTS_WITH,
                    OPERATOR_ENDS_WITH,
                    OPERATOR_CONTAINS,
                    OPERATOR_NOT_CONTAINS
                    ])
                ) {
                    return new StringFilter($field, $operator, $value);
                }
                break;
        }
        return null;
    }
}
