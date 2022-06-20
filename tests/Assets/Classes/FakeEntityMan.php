<?php

namespace MikroTest\Assets\Classes;

use MikroTest\Assets\Classes\FakeEntityPerson;

class FakeEntityMan extends FakeEntityPerson
{
    private string $type = 'MAN';

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
