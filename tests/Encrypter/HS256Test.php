<?php

namespace MikroTest\Encrypter;

use PHPUnit\Framework\TestCase;
use Mikro\Encrypter\HS256;

class HS256Test extends TestCase
{
    /**
     * Verifica corretta creazione assegnazione e recupero dati
     */
    public function testGetAndSet()
    {
        $encrypter = new HS256('fraseD1Es3mpi0Us4taPerCr1pTar3eD3crypTAR3@');
        $this->assertEquals('fraseD1Es3mpi0Us4taPerCr1pTar3eD3crypTAR3@', $encrypter->getEncodeKey());
        $this->assertEquals('fraseD1Es3mpi0Us4taPerCr1pTar3eD3crypTAR3@', $encrypter->getDecodeKey());
        $this->assertEquals('HS256', $encrypter->getAlg());
    }
}
