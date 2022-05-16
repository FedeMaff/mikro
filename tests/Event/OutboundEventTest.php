<?php

namespace MikroTest\Event;

use PHPUnit\Framework\TestCase;
use Mikro\Event\OutboundEvent;

class OutboundEventTest extends TestCase
{
    /**
     * Verifica creazione evneto in uscita
     */
    public function testCreation()
    {
        $outboundEvent = new OutboundEvent("EventoDiProva", [], "pierpippo29", 20);

        /* {
            "id": "EVENTBC5FEC5176937CF9708C42EABAB",
            "name": "EventoDiProva",
            "sender": "Mikro",
            "creationDate": "2022-05-03 15:18:37",
            "referenceId": "pierpippo29",
            "expiresIn": 20
        } */

        $this->assertEquals(EVENT_ID_LENGTH, strlen($outboundEvent->getId()));
        $this->assertEquals(EVENT_ID_PREFIX, substr($outboundEvent->getId(), 0, 5));
        $this->assertEquals('EventoDiProva', $outboundEvent->getName());
        $this->assertEquals('Mikro', $outboundEvent->getSender());
        $this->assertInstanceOf("\DateTime", $outboundEvent->getCreationDate());
        $this->assertEquals("pierpippo29", $outboundEvent->getReferenceId());
        $this->assertEquals(20, $outboundEvent->getExpiresIn());
    }
}
