<?php

namespace MikroTest\Factory;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\HttpResponseFactory;
use Mikro\File\File;

class HttpResponseFactoryTest extends TestCase
{
    /**
     * Verifica corretta creazione istanza FileHttpResponse
     */
    public function testRecoveryFileHttpResponse()
    {
        $file = new File(__DIR__ . '/tmp/image.png');
        $response = HttpResponseFactory::create($file, 200);
        $this->assertInstanceOf('Mikro\Response\FileHttpResponse', $response);
    }
}
