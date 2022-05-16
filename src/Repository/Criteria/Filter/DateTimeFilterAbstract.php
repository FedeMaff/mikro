<?php

/**
 * DateTimeFilterAbstract.php
 * Mikro\Repository\Criteria\Filter\Filter\DateTimeFilterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository\Criteria\Filter;

use Mikro\Repository\Criteria\Filter\FilterAbstract;
use Mikro\Repository\Criteria\Filter\DateTimeFilterInterface;
use DateTime;

/**
 * Implementazione astratta filtro data ora
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
abstract class DateTimeFilterAbstract extends FilterAbstract implements DateTimeFilterInterface
{
    /**
     * Valore data ora
     *
     * @var DateTime
     */
    private ?DateTime $value = null;

    /**
     * Costruttore
     *
     * @param string $field Nome proprietà / field
     * @param string $operator Operatore
     * @param DateTime $value Valore data ora
     *
     * @return void
     */
    public function __construct(string $field, string $operator, DateTime $value)
    {
        parent::__construct($field, $operator);
        $this->value = $value;
    }

    /**
     * Recupero valore istanza DateTime ( data ora )
     *
     * @return DateTime
     */
    public function getValue(): DateTime
    {
        return $this->value;
    }
}
