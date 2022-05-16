<?php

namespace MikroTest\Repository\Criteria\Filter;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filter\DateTimeFilter;
use \DateTime;

class DateTimeFilterTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $filter = new DateTimeFilter('accessdate', OPERATOR_EQUAL, new DateTime('2022-01-19 10:30:12'));
        $this->assertEquals('accessdate', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-01-19 10:30:12'), $filter->getValue());

        $filter = new DateTimeFilter('logindate', OPERATOR_NOT_EQUAL, new DateTime('2022-01-19 00:00:01'));
        $this->assertEquals('logindate', $filter->getField());
        $this->assertEquals(OPERATOR_NOT_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-01-19 00:00:01'), $filter->getValue());

        $filter = new DateTimeFilter('deleteddate', OPERATOR_LESS_THAN, new DateTime('2020-10-11 19:21:05'));
        $this->assertEquals('deleteddate', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN, $filter->getOperator());
        $this->assertEquals(new DateTime('2020-10-11 19:21:05'), $filter->getValue());

        $filter = new DateTimeFilter('badday', OPERATOR_LESS_THAN_OR_EQUAL, new DateTime('2022-01-01 12:30:31'));
        $this->assertEquals('badday', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-01-01 12:30:31'), $filter->getValue());

        $filter = new DateTimeFilter('birthdate', OPERATOR_GREATER_THAN, new DateTime('1989-01-23 23:42:40'));
        $this->assertEquals('birthdate', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN, $filter->getOperator());
        $this->assertEquals(new DateTime('1989-01-23 23:42:40'), $filter->getValue());

        $filter = new DateTimeFilter('lastorderdate', OPERATOR_GREATER_THAN_OR_EQUAL, new DateTime('2022-02-01 18:12:31'));
        $this->assertEquals('lastorderdate', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(new DateTime('2022-02-01 18:12:31'), $filter->getValue());        
    }
}
