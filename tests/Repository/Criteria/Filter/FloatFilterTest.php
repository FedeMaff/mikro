<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\FloatFilter;

class FloatFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new FloatFilter('amount', OPERATOR_EQUAL, 19.29);
        $this->assertEquals('amount', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals(19.29, $filter->getValue());

        $filter = new FloatFilter('credits', OPERATOR_NOT_EQUAL, 90.90);
        $this->assertEquals('credits', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_EQUAL, $filter->getOperator());
        $this->assertEquals(90.90, $filter->getValue());

        $filter = new FloatFilter('unit', OPERATOR_LESS_THAN, 2);
        $this->assertEquals('unit', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN, $filter->getOperator());
        $this->assertEquals(2, $filter->getValue());

        $filter = new FloatFilter('percentage', OPERATOR_LESS_THAN_OR_EQUAL, 90.92);
        $this->assertEquals('percentage', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(90.92, $filter->getValue());

        $filter = new FloatFilter('price', OPERATOR_GREATER_THAN, 9.90);
        $this->assertEquals('price', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN, $filter->getOperator());
        $this->assertEquals(9.90, $filter->getValue());

        $filter = new FloatFilter('costo', OPERATOR_GREATER_THAN_OR_EQUAL, 18.90192);
        $this->assertEquals('costo', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(18.90192, $filter->getValue());        
    }
}
