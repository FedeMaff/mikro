<?php

namespace MikroTest\RoutingList;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\ControllerKeyFactory;
use Mikro\RoutingList\RoutingListItem;

class RoutingListItemTest extends TestCase
{
    /**
     * Verifica corretta creazione
     */
    public function testCreation()
    {
        $className = 'MikroTest\Assets\Classes\FakeHttpController';
        $key = ControllerKeyFactory::create($className);
        $item = new RoutingListItem($className, $key);
        $this->assertEquals($className, $item->getClassName());
        $this->assertInstanceOf('Mikro\ControllerKey\ControllerKeyInterface', $item->getKey());
    }
}
