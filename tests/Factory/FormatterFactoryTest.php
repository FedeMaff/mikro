<?php

namespace MikroTest\Factory;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\FormatterFactory;

class FormatterFactoryTest extends TestCase
{
    /**
     * Verifica corretta creazione formatter JSON
     */
    public function testFactoryJsonFormatter()
    {
        $formatter = FormatterFactory::create(TYPE_JSON);
        $this->assertInstanceOf('Mikro\Response\Formatter\JsonFormatter', $formatter);
    }

    /**
     * Verifica fold-back creazione formatter JSON se non specificato diversamente
     */
    public function testFactoryFoldBackFormatter()
    {
        $formatter = FormatterFactory::create('minerale');
        $this->assertInstanceOf('Mikro\Response\Formatter\JsonFormatter', $formatter);
    }
}
