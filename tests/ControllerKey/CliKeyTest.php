<?php

namespace MikroTest\ControllerKey;

use PHPUnit\Framework\TestCase;
use Mikro\ControllerKey\CliKey;

class CliKeyTest extends TestCase
{
    /**
     * Verifica corretta creazione
     */
    public function testCreation()
    {
        $className = 'MikroTest\Assets\Classes\FakeCliController';
        $key = new CliKey($className);
        $this->assertEquals('salutami', $key->getCommandName());
    }
}
