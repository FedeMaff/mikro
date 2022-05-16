<?php

/**
 * IntFilterAbstract.php
 * Mikro\Repository\Criteria\Filter\Filter\IntFilterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterAbstract;
use Mikro\Repository\Criteria\Filter\IntFilterInterface;

/**
 * Implementazione concreta filtro numero intero
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
abstract class IntFilterAbstract extends FilterAbstract implements IntFilterInterface
{
    /**
     * Valore intero
     *
     * @var int
     */
    private ?int $value = null;

    /**
     * Costruttore
     *
     * @param string $field Nome proprietà / field
     * @param string $operator Operatore
     * @param int $value Valore intero
     *
     * @return void
     */
    public function __construct(string $field, string $operator, int $value)
    {
        parent::__construct($field, $operator);
        $this->value = $value;
    }

    /**
     * Recupero valore intero
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
