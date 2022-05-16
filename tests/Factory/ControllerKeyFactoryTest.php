<?php

namespace MikroTest\Factory;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\ControllerKeyFactory;

class ControllerKeyFactoryTest extends TestCase
{
    /**
     * Verifica corretta creazione HttpKey
     */
    public function testFactoryHttpKey()
    {
        $key = ControllerKeyFactory::create('MikroTest\Assets\Classes\FakeHttpController');
        $this->assertInstanceOf('Mikro\ControllerKey\HttpKeyInterface', $key);
    }

    /**
     * Verifica corretta creazione AmqpKey
     */
    public function testFactoryAmqpKey()
    {
        $key = ControllerKeyFactory::create('MikroTest\Assets\Classes\FakeAmqpController');
        $this->assertInstanceOf('Mikro\ControllerKey\AmqpKeyInterface', $key);
    }

    /**
     * Verifica corretta creazione CliKey
     */
    public function testFactoryCliKey()
    {
        $key = ControllerKeyFactory::create('MikroTest\Assets\Classes\FakeCliController');
        $this->assertInstanceOf('Mikro\ControllerKey\CliKeyInterface', $key);
    }
}
