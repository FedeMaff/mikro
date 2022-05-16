<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\StringResponse;

class StringResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati
     */
    public function testCreation()
    {
        $response = new StringResponse('Prova di testo di risposta');
        $this->assertEquals('Prova di testo di risposta', sprintf($response));
    }
}
