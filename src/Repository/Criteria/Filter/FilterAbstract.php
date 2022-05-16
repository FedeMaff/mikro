<?php

/**
 * FilterAbstract.php
 * Mikro\Repository\Criteria\Filter\Filter\Filter\FilterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterInterface;

/**
 * Implementazione astratta filtro di lettura
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class FilterAbstract implements FilterInterface
{
    /**
     * Nome proprietà / field
     *
     * @var ?string $field Nome proprietà / field
     */
    private ?string $field = null;

    /**
     * Operatore
     *
     * @var ?string $operator Operatore
     */
    private ?string $operator = null;

    /**
     * Costruttore
     *
     * @param string $field Nome proprietà / field
     * @param string $operator Operatore
     *
     * @return void
     */
    public function __construct(string $field, string $operator)
    {
        $this->field = $field;
        $this->operator = $operator;
    }

    /**
     * Recupero nome field di riferimento
     *
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Recupero operatore
     *
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }
}
