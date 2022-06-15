<?php

namespace MikroTest\Assets\Classes;

use Mikro\Encrypter\HS256;

class FakeHS256Encrypter extends HS256
{
    public function __construct()
    {
        parent::__construct('frase-segreta-usata-per-criptare');
    }
}
