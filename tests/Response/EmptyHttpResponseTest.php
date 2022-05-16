<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\EmptyHttpResponse;

class EmptyHttpResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e stampa empty http response
     */
    public function testPrint()
    {
        $response = new EmptyHttpResponse(OK);
        $this->assertEquals(OK, $response->getStatusCode());
        $this->assertEquals('', sprintf($response));
    }    
}
