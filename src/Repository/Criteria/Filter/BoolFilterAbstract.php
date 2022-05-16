<?php

/**
 * BoolFilterAbstract.php
 * Mikro\Repository\Criteria\Filter\Filter\BoolFilterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterAbstract;
use Mikro\Repository\Criteria\Filter\BoolFilterInterface;

/**
 * Implementazione astratta filtro buleano
 *
 * Operatori:
 *
 * OPERATOR_EQUAL
 * OPERATOR_NOT_EQUAL
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class BoolFilterAbstract extends FilterAbstract implements BoolFilterInterface
{
    /**
     * Valore buleano
     *
     * @var bool
     */
    private ?bool $value = null;

    /**
     * Costruttore
     *
     * @param string $field Nome proprietà / field
     * @param string $operator Operatore
     * @param bool $value Valore buleano
     *
     * @return void
     */
    public function __construct(string $field, string $operator, bool $value)
    {
        parent::__construct($field, $operator);
        $this->value = $value;
    }

    /**
     * Recupero valore buleano
     *
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }
}
