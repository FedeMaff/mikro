<?php

namespace MikroTest\Assets\Classes;

use Mikro\Controller\CliController;

class FakeCliController extends CliController
{
    protected static string $commandName = 'salutami';
}
