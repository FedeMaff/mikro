<?php

namespace MikroTest\Encrypter;

use PHPUnit\Framework\TestCase;
use Mikro\Encrypter\RS256;

class RS256Test extends TestCase
{
    /**
     * Verifica corretta creazione assegnazione e recupero dati
     */
    public function testGetAndSet()
    {
        $privateKey = 'Questa3UnaChiavePriv4ta!';
        $publicKey = 'QuestaEl4Pubblica!@!@!';
        $encrypter = new RS256($privateKey, $publicKey);
        $this->assertEquals($privateKey, $encrypter->getEncodeKey());
        $this->assertEquals($publicKey, $encrypter->getDecodeKey());
        $this->assertEquals('RS256', $encrypter->getAlg());
    }
}
