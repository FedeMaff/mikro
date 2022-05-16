<?php

namespace MikroTest\RoutingManager;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\RoutingListFactory;
use Mikro\RoutingManager\AmqpRoutingManager;
use MikroTest\Assets\Classes\FakeAmqpRequest;

class AmqpRoutingManagerTest extends TestCase
{
    /**
     * Verifica recupero controller
     */
    public function testAddAndGet()
    {
        $nameSpaces = ['MikroTest'];
        $list = RoutingListFactory::create($nameSpaces);

        $manager = new AmqpRoutingManager($list, new FakeAmqpRequest());
        $controller = $manager->getController();

        $this->assertInstanceOf('MikroTest\Assets\Classes\FakeAmqpController', $controller);
    }
}
