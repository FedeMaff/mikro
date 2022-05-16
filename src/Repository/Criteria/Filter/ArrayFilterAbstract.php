<?php

/**
 * ArrayFilterAbstract.php
 * Mikro\Repository\Criteria\Filter\Filter\ArrayFilterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterAbstract;
use Mikro\Repository\Criteria\Filter\ArrayFilterInterface;

/**
 * Implementazione astratta filtro array
 *
 * Operatori:
 *
 * OPERATOR_IN
 * OPERATOR_NOT_IN
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class ArrayFilterAbstract extends FilterAbstract implements ArrayFilterInterface
{
    /**
     * Valore array
     *
     * @var string[]
     */
    private ?array $value = null;

    /**
     * Costruttore
     *
     * @param string $field Nome proprietà / field
     * @param string $operator Operatore
     * @param string[] $value Valore array
     *
     * @return void
     */
    public function __construct(string $field, string $operator, array $value)
    {
        parent::__construct($field, $operator);
        $this->value = $value;
    }

    /**
     * Recupero valore array
     *
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
