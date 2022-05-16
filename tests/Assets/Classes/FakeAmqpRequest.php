<?php

namespace MikroTest\Assets\Classes;

use Mikro\Request\AmqpRequestInterface;

class FakeAmqpRequest implements AmqpRequestInterface
{
    public function getEventName(): string
    {
        return 'registrataFugaDiGas';
    }

    public function getData(): array
    {
        return ['indirizzo' => ['citta' => 'Torino', 'cap' => '10060']];
    }
}
