<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\StringHttpResponse;

class StringHttpResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati
     */
    public function testCreation()
    {
        $response = new StringHttpResponse('Prova di testo di risposta', OK);
        $this->assertEquals('Prova di testo di risposta', sprintf($response));
        $this->assertEquals(OK, $response->getStatusCode());
        $this->assertEquals(['Content-Type' => 'text/plain; charset=utf-8'], $response->getHeaders());
    }
}
