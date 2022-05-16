<?php

/**
 * StringFilterAbstract.php
 * Mikro\Repository\Criteria\Filter\Filter\StringFilterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterAbstract;
use Mikro\Repository\Criteria\Filter\StringFilterInterface;

/**
 * Implementazione astratta filtro stringa
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
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class StringFilterAbstract extends FilterAbstract implements StringFilterInterface
{
    /**
     * Valore stringa
     *
     * @var string
     */
    private ?string $value = null;

    /**
     * Costruttore
     *
     * @param string $field Nome proprietà / field
     * @param string $operator Operatore
     * @param string $value Valore stringa
     *
     * @return void
     */
    public function __construct(string $field, string $operator, string $value)
    {
        parent::__construct($field, $operator);
        $this->value = $value;
    }

    /**
     * Recupero valore stringa
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
