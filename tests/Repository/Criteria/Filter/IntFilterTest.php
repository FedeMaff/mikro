<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\IntFilter;

class IntFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new IntFilter('quantity', OPERATOR_EQUAL, 21);
        $this->assertEquals('quantity', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals(21, $filter->getValue());

        $filter = new IntFilter('year', OPERATOR_NOT_EQUAL, 12);
        $this->assertEquals('year', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_EQUAL, $filter->getOperator());
        $this->assertEquals(12, $filter->getValue());

        $filter = new IntFilter('views', OPERATOR_LESS_THAN, 10);
        $this->assertEquals('views', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN, $filter->getOperator());
        $this->assertEquals(10, $filter->getValue());

        $filter = new IntFilter('click', OPERATOR_LESS_THAN_OR_EQUAL, 213);
        $this->assertEquals('click', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(213, $filter->getValue());

        $filter = new IntFilter('like', OPERATOR_GREATER_THAN, 89);
        $this->assertEquals('like', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN, $filter->getOperator());
        $this->assertEquals(89, $filter->getValue());

        $filter = new IntFilter('invii', OPERATOR_GREATER_THAN_OR_EQUAL, 129);
        $this->assertEquals('invii', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(129, $filter->getValue());        
    }
}
