<?php

namespace MikroTest\RoutingManager;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\RoutingListFactory;
use Mikro\RoutingManager\HttpRoutingManager;
use MikroTest\Assets\Classes\FakeHttpRequest;
use MikroTest\Assets\Classes\FakeHttpRequestWithPathVariables;

class HttpRoutingManagerTest extends TestCase
{
    /**
     * Verifica recupero controller
     */
    public function testAddAndGet()
    {
        $nameSpaces = ['MikroTest'];
        $list = RoutingListFactory::create($nameSpaces);

        $manager = new HttpRoutingManager($list, new FakeHttpRequest());
        $controller = $manager->getController();

        $this->assertInstanceOf('MikroTest\Assets\Classes\FakeHttpController', $controller);
    }

    /**
     * Verifica recupero controller con path variables
     */
    public function testAddAndGetPathVariables()
    {
        $nameSpaces = ['MikroTest'];
        $list = RoutingListFactory::create($nameSpaces);

        $manager = new HttpRoutingManager($list, new FakeHttpRequestWithPathVariables());
        $controller = $manager->getController();

        $this->assertInstanceOf('MikroTest\Assets\Classes\FakeHttpControllerWithPathVariables', $controller);
    }
}
