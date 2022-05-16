<?php

namespace MikroTest\Assets\Classes;

use Mikro\Request\CliRequestInterface;

class FakeCliRequest implements CliRequestInterface
{
    public function getCommandName(): string
    {
        return 'salutami';
    }

    public function getData(): array
    {
        return ['nomi' => ['Federico', 'Gabriele']];
    }
}
