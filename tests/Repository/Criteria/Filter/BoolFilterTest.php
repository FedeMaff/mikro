<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\BoolFilter;
use \DateTime;

class BoolFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new BoolFilter('isactive', OPERATOR_EQUAL, true);
        $this->assertEquals('isactive', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals(true, $filter->getValue());

        $filter = new BoolFilter('deleted', OPERATOR_NOT_EQUAL, false);
        $this->assertEquals('deleted', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_EQUAL, $filter->getOperator());
        $this->assertEquals(false, $filter->getValue());   
    }
}
