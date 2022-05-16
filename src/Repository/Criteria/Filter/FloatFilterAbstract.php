<?php

/**
 * FloatFilterAbstract.php
 * Mikro\Repository\Criteria\Filter\Filter\FloatFilterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterAbstract;
use Mikro\Repository\Criteria\Filter\FloatFilterInterface;

/**
 * Implementazione astratta filtro numero con decimali
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
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class FloatFilterAbstract extends FilterAbstract implements FloatFilterInterface
{
    /**
     * Valore numero con decimali
     *
     * @var float
     */
    private ?float $value = null;

    /**
     * Costruttore
     *
     * @param string $field Nome proprietà / field
     * @param string $operator Operatore
     * @param float $value Valore numero con decimali
     *
     * @return void
     */
    public function __construct(string $field, string $operator, float $value)
    {
        parent::__construct($field, $operator);
        $this->value = $value;
    }

    /**
     * Recupero valore numero con decimali
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
