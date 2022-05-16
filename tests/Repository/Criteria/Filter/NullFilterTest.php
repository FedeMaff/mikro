<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\NullFilter;

class NullFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new NullFilter('activationdate', OPERATOR_IS_NULL);
        $this->assertEquals('activationdate', $filter->getField());
        $this->assertEquals(OPERATOR_IS_NULL, $filter->getOperator());

        $filter = new NullFilter('lastlogindate', OPERATOR_IS_NOT_NULL);
        $this->assertEquals('lastlogindate', $filter->getField());
        $this->assertEquals(OPERATOR_IS_NOT_NULL, $filter->getOperator());
    }
}
