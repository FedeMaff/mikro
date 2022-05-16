<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\DateFilter;
use \DateTime;

class DateFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new DateFilter('accessdate', OPERATOR_EQUAL, new DateTime('2022-01-19'));
        $this->assertEquals('accessdate', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-01-19'), $filter->getValue());

        $filter = new DateFilter('logindate', OPERATOR_NOT_EQUAL, new DateTime('2022-01-19'));
        $this->assertEquals('logindate', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-01-19'), $filter->getValue());

        $filter = new DateFilter('deleteddate', OPERATOR_LESS_THAN, new DateTime('2020-10-11'));
        $this->assertEquals('deleteddate', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN, $filter->getOperator());
        $this->assertEquals(new DateTime('2020-10-11'), $filter->getValue());

        $filter = new DateFilter('badday', OPERATOR_LESS_THAN_OR_EQUAL, new DateTime('2022-01-01'));
        $this->assertEquals('badday', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-01-01'), $filter->getValue());

        $filter = new DateFilter('birthdate', OPERATOR_GREATER_THAN, new DateTime('1989-01-23'));
        $this->assertEquals('birthdate', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN, $filter->getOperator());
        $this->assertEquals(new DateTime('1989-01-23'), $filter->getValue());

        $filter = new DateFilter('lastorderdate', OPERATOR_GREATER_THAN_OR_EQUAL, new DateTime('2022-02-01'));
        $this->assertEquals('lastorderdate', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-02-01'), $filter->getValue());        
    }
}
