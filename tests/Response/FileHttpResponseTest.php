<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\FileHttpResponse;

class FileHttpResponseTest extends TestCase
{
    /**
     * Verifica inzializzazione da path
     */
    public function testCreationJson()
    {
        $filePath = __DIR__ . '/tmp/image.png';
        $response = new FileHttpResponse($filePath);
        $this->assertEquals($filePath, $response->getFilePath());
        $this->assertEquals(['Content-Type' => 'image/png;'], $response->getHeaders());
        $this->assertEquals(file_get_contents($filePath), $response);
    }
}
