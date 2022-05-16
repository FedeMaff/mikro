<?php

namespace MikroTest\RoutingManager;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\RoutingListFactory;
use Mikro\RoutingManager\CliRoutingManager;
use MikroTest\Assets\Classes\FakeCliRequest;

class CliRoutingManagerTest extends TestCase
{
    /**
     * Verifica recupero controller
     */
    public function testAddAndGet()
    {
        $nameSpaces = ['MikroTest'];
        $list = RoutingListFactory::create($nameSpaces);

        $manager = new CliRoutingManager($list, new FakeCliRequest());
        $controller = $manager->getController();

        $this->assertInstanceOf('MikroTest\Assets\Classes\FakeCliController', $controller);
    }
}
