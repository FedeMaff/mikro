<?php

namespace MikroTest\Repository\Criteria;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Pagination;

class PaginationTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati paginazione
     */
    public function testCreation()
    {
        $pagination = new Pagination();
        $this->assertEquals(1, $pagination->getPage());
        $this->assertEquals(DEFAULT_PAGINATION, $pagination->getLimit());

        $pagination = new Pagination(4, 100);
        $this->assertEquals(4, $pagination->getPage());
        $this->assertEquals(100, $pagination->getLimit());

        $pagination = new Pagination(-29, -130);
        $this->assertEquals(29, $pagination->getPage());
        $this->assertEquals(130, $pagination->getLimit());

        $pagination = new Pagination(7);
        $this->assertEquals(7, $pagination->getPage());
        $this->assertEquals(DEFAULT_PAGINATION, $pagination->getLimit());
    }
}
