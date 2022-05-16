<?php

namespace MikroTest\EntityCollection;

use PHPUnit\Framework\TestCase;
use Mikro\EntityCollection\EntityCollection;

class EntityCollectionTest extends TestCase
{
    /**
     * Verifica corretta creazione assegnazione e recupero dati
     */
    public function testSetAndGet()
    {
        $collection = new EntityCollection(null, null, null, null, ...[]);
        $this->assertEquals(1, $collection->getPage());
        $this->assertEquals(DEFAULT_PAGINATION, $collection->getLimit());
        $this->assertEquals(1, $collection->getPages());
        $this->assertEquals(0, $collection->getTotal());
        $this->assertEquals([], $collection->getItems());

        $collection = new EntityCollection(10, 130, 20, 2600, ...[]);
        $this->assertEquals(10, $collection->getPage());
        $this->assertEquals(130, $collection->getLimit());
        $this->assertEquals(20, $collection->getPages());
        $this->assertEquals(2600, $collection->getTotal());
        $this->assertEquals([], $collection->getItems());
    }
}
