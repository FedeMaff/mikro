<?php

namespace MikroTest\Response;

use PHPUnit\Framework\TestCase;
use Mikro\Response\FileResponse;

class FileResponseTest extends TestCase
{
    /**
     * Verifica inzializzazione da path
     */
    public function testCreationJson()
    {
        $filePath = __DIR__ . '/tmp/image.png';
        $response = new FileResponse($filePath);
        $this->assertEquals($filePath, $response->getFilePath());
        $this->assertEquals(file_get_contents($filePath), $response);
    }
}
