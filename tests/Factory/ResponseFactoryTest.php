<?php

namespace MikroTest\Factory;

use PHPUnit\Framework\TestCase;
use Mikro\Factory\ResponseFactory;
use Mikro\File\File;

class ResponseFactoryTest extends TestCase
{
    /**
     * Verifica corretta creazione istanza FileResponse
     */
    public function testRecoveryFileResponse()
    {
        $file = new File(__DIR__ . '/tmp/image.png');
        $response = ResponseFactory::create($file);
        $this->assertInstanceOf('Mikro\Response\FileResponse', $response);
    }
}
