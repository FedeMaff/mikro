<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\ArrayFilter;
use \DateTime;

class ArrayFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new ArrayFilter('color', OPERATOR_IN, ['rosso', 'blu', 'giallo']);
        $this->assertEquals('color', $filter->getField());
        $this->assertEquals(OPERATOR_IN, $filter->getOperator());
        $this->assertEquals(['rosso', 'blu', 'giallo'], $filter->getValue());

        $filter = new ArrayFilter('userid', OPERATOR_NOT_IN, [12, 23, 40, 51]);
        $this->assertEquals('userid', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_IN, $filter->getOperator());
        $this->assertEquals([12, 23, 40, 51], $filter->getValue());   
    }
}
