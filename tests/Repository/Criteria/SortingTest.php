<?php

namespace MikroTest\Repository\Criteria;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Sorting;

class SortingTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $sorting = new Sorting('name');
        $this->assertEquals('name', $sorting->getField());
        $this->assertEquals(DEFAULT_ORDER, $sorting->getOrder());

        $sorting = new Sorting('surname', ORDER_DESC);
        $this->assertEquals('surname', $sorting->getField());
        $this->assertEquals(ORDER_DESC, $sorting->getOrder());

        $sorting = new Sorting('email', ORDER_ASC);
        $this->assertEquals('email', $sorting->getField());
        $this->assertEquals(ORDER_ASC, $sorting->getOrder());
    }
}
