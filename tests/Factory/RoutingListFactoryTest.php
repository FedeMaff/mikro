<?php

namespace MikroTest\Factory;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\RoutingListFactory;

class RoutingListFactoryTest extends TestCase
{
    /**
     * Verifica corretta creazione istanza RoutingListItem
     */
    public function testCreation()
    {
        $nameSpaces = ['MikroTest'];
        $list = RoutingListFactory::create($nameSpaces);
        $this->assertInstanceOf('Mikro\RoutingList\RoutingListInterface', $list);
        $this->assertContainsOnlyInstancesOf('Mikro\RoutingList\RoutingListItemInterface', $list->getItems());
    }
}
