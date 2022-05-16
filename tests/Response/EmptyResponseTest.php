<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\EmptyResponse;

class EmptyResponseTest extends TestCase
{
    /**
     * Verifica corretta creazione e stampa empty response
     */
    public function testPrint()
    {
        $response = new EmptyResponse();
        $this->assertEquals('', sprintf($response));
    }    
}
