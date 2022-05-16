<?php

namespace MikroTest\RoutingList;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\ControllerKeyFactory;
use Mikro\RoutingList\RoutingList;
use Mikro\RoutingList\RoutingListItem;

class RoutingListTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero elmenti
     */
    public function testAddAndGet()
    {
        $className = 'MikroTest\Assets\Classes\FakeHttpController';
        $key = ControllerKeyFactory::create($className);
        $item1 = new RoutingListItem($className, $key);

        $className = 'MikroTest\Assets\Classes\FakeAmqpController';
        $key = ControllerKeyFactory::create($className);
        $item2 = new RoutingListItem($className, $key);

        $list = new RoutingList();
        $list->addItem($item1);
        $list->addItem($item2);

        $this->assertEquals(2, count($list->getItems()));
        $this->assertContainsOnlyInstancesOf('Mikro\RoutingList\RoutingListItemInterface', $list->getItems());
    }

    /**
     * Verifica getHttpItems
     */
    public function testGetHttpItems()
    {
        $className = 'MikroTest\Assets\Classes\FakeHttpController';
        $key = ControllerKeyFactory::create($className);
        $item1 = new RoutingListItem($className, $key);

        $className = 'MikroTest\Assets\Classes\FakeAmqpController';
        $key = ControllerKeyFactory::create($className);
        $item2 = new RoutingListItem($className, $key);

        $list = new RoutingList();
        $list->addItem($item1);
        $list->addItem($item2);

        $this->assertCount(1, $list->getHttpItems());
    }

    /**
     * Verifica getAmqpItems
     */
    public function testGetAmqpItems()
    {
        $className = 'MikroTest\Assets\Classes\FakeCliController';
        $key = ControllerKeyFactory::create($className);
        $item1 = new RoutingListItem($className, $key);

        $className = 'MikroTest\Assets\Classes\FakeAmqpController';
        $key = ControllerKeyFactory::create($className);
        $item2 = new RoutingListItem($className, $key);

        $list = new RoutingList();
        $list->addItem($item1);
        $list->addItem($item2);

        $this->assertCount(1, $list->getAmqpItems());
    }

    /**
     * Verifica getCliItems
     */
    public function testGetCliItems()
    {
        $className = 'MikroTest\Assets\Classes\FakeCliController';
        $key = ControllerKeyFactory::create($className);
        $item1 = new RoutingListItem($className, $key);

        $className = 'MikroTest\Assets\Classes\FakeHttpController';
        $key = ControllerKeyFactory::create($className);
        $item2 = new RoutingListItem($className, $key);

        $list = new RoutingList();
        $list->addItem($item1);
        $list->addItem($item2);

        $this->assertCount(1, $list->getCliItems());
    }
}
