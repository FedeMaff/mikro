<?php

namespace MikroTest\ControllerKey;

use PHPUnit\Framework\TestCase;
use Mikro\ControllerKey\HttpKey;

class HttpKeyTest extends TestCase
{
    /**
     * Verifica corretta creazione
     */
    public function testCreation()
    {
        $className = 'MikroTest\Assets\Classes\FakeHttpController';
        $key = new HttpKey($className);
        $this->assertEquals('POST', $key->getMethod());
        $this->assertEquals('/microservizio/v1/customers', $key->getPath());
    }
}
