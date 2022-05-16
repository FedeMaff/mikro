<?php

namespace MikroTest\Assets\Classes;

use Mikro\Controller\AmqpController;

class FakeAmqpController extends AmqpController
{
    protected static string $eventName = 'registrataFugaDiGas';
}
