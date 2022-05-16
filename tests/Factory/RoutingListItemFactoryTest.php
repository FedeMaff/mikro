<?php

namespace MikroTest\Factory;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\RoutingListItemFactory;

class RoutingListItemFactoryTest extends TestCase
{
    /**
     * Verifica corretta creazione istanza RoutingListItem
     */
    public function testCreation()
    {
        $className = 'MikroTest\Assets\Classes\FakeHttpController';
        $item = RoutingListItemFactory::create($className);
        $this->assertInstanceOf('Mikro\RoutingList\RoutingListItemInterface', $item);
    }
}
