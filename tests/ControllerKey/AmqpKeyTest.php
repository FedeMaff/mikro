<?php

namespace MikroTest\ControllerKey;

use PHPUnit\Framework\TestCase;
use Mikro\ControllerKey\AmqpKey;

class AmqpKeyTest extends TestCase
{
    /**
     * Verifica corretta creazione
     */
    public function testCreation()
    {
        $className = 'MikroTest\Assets\Classes\FakeAmqpController';
        $key = new AmqpKey($className);
        $this->assertEquals('registrataFugaDiGas', $key->getEventName());
    }
}
