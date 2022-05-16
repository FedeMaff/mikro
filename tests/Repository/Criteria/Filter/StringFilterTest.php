<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\StringFilter;

class StringFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new StringFilter('name', OPERATOR_EQUAL, 'federico');
        $this->assertEquals('name', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals('federico', $filter->getValue());

        $filter = new StringFilter('surname', OPERATOR_NOT_EQUAL, 'rossi');
        $this->assertEquals('surname', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_EQUAL, $filter->getOperator());
        $this->assertEquals('rossi', $filter->getValue());

        $filter = new StringFilter('customername', OPERATOR_STARTS_WITH, 'piag');
        $this->assertEquals('customername', $filter->getField());
        $this->assertEquals(OPERATOR_STARTS_WITH, $filter->getOperator());
        $this->assertEquals('piag', $filter->getValue());

        $filter = new StringFilter('supplier', OPERATOR_ENDS_WITH, 'gio');
        $this->assertEquals('supplier', $filter->getField());
        $this->assertEquals(OPERATOR_ENDS_WITH, $filter->getOperator());
        $this->assertEquals('gio', $filter->getValue());

        $filter = new StringFilter('rapstarname', OPERATOR_CONTAINS, 'ax');
        $this->assertEquals('rapstarname', $filter->getField());
        $this->assertEquals(OPERATOR_CONTAINS, $filter->getOperator());
        $this->assertEquals('ax', $filter->getValue());

        $filter = new StringFilter('actorname', OPERATOR_NOT_CONTAINS, 'gli');
        $this->assertEquals('actorname', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_CONTAINS, $filter->getOperator());
        $this->assertEquals('gli', $filter->getValue());
    }
}
