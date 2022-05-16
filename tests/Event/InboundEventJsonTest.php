<?php

namespace MikroTest\Event;

use PHPUnit\Framework\TestCase;
use Mikro\Event\InboundEventJson;
use Mikro\Exceptions\JsonStringException;
use Mikro\Exceptions\NotFoundException;
use Mikro\Exceptions\NotValidException;

class InboundEventJsonTest extends TestCase
{
    /**
     * Verifica creazione evneto JSON in ingresso
     */
    public function testCreation()
    {
        $jsonEvent = <<<EOF
        {
            "id": "EVENTBC5FEC5176937CF9708C42EABAB",
            "name": "EventoDiProva",
            "sender": "Mikro",
            "creationDate": "2022-05-03 15:18:37",
            "data": {
                "nome": "Federico",
                "cognome": "Maffucci"
            },
            "referenceId": "pierpippo29",
            "expiresIn": 20
        }
        EOF;

        $inboundEvent = new InboundEventJson($jsonEvent);

        $this->assertEquals("EVENTBC5FEC5176937CF9708C42EABAB", $inboundEvent->getId());
        $this->assertEquals('EventoDiProva', $inboundEvent->getName());
        $this->assertEquals('Mikro', $inboundEvent->getSender());
        $this->assertInstanceOf("\DateTime", $inboundEvent->getCreationDate());
        $this->assertEquals("pierpippo29", $inboundEvent->getReferenceId());
        $this->assertEquals(20, $inboundEvent->getExpiresIn());
        $this->assertEquals("Federico", $inboundEvent->getData()["nome"]);
        $this->assertEquals("Maffucci", $inboundEvent->getData()["cognome"]);
    }

    /**
     * Verifica creazione evneto JSON in ingresso senza id
     */
    public function testCreationNoJson()
    {
        $jsonEvent = <<<EOF
        {e","creationDate":"2022-05-03 15:18:37"}
        EOF;

        $expectedMsg = <<<EOF
        Nel gestire un evento AMQP in ingresso non e' stato possibile decodificare in modo corretto il contenuto.
        EOF;

        $this->expectException(JsonStringException::class);
        $this->expectExceptionMessage($expectedMsg);
        new InboundEventJson($jsonEvent);
    }

    /**
     * Verifica creazione evneto JSON in ingresso senza id
     */
    public function testCreationWithoutId()
    {
        $jsonEvent = <<<EOF
        {"name":"EventoDiProva","sender":"Mikro","creationDate":"2022-05-03 15:18:37"}
        EOF;

        $expectedMsg = <<<EOF
        Nel gestire il parsing di un evento AMQP in ingresso non e' stato possibile leggere la proprieta' obbligatoria "id". L'array JSON di riferimento e' il seguente: {"name":"EventoDiProva","sender":"Mikro","creationDate":"2022-05-03 15:18:37"}
        EOF;

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage($expectedMsg);
        new InboundEventJson($jsonEvent);
    }

    /**
     * Verifica creazione evneto JSON in ingresso senza name
     */
    public function testCreationWithoutName()
    {
        $jsonEvent = <<<EOF
        {"id":"EVENTBC5FEC5176937CF9708C42EABAB","sender":"Mikro","creationDate":"2022-05-03 15:18:37"}
        EOF;

        $expectedMsg = <<<EOF
        Nel gestire il parsing di un evento AMQP in ingresso non e' stato possibile leggere la proprieta' obbligatoria "name". L'array JSON di riferimento e' il seguente: {"id":"EVENTBC5FEC5176937CF9708C42EABAB","sender":"Mikro","creationDate":"2022-05-03 15:18:37"}
        EOF;

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage($expectedMsg);
        new InboundEventJson($jsonEvent);
    }

    /**
     * Verifica creazione evneto JSON in ingresso senza sender
     */
    public function testCreationWithoutSender()
    {
        $jsonEvent = <<<EOF
        {"id":"EVENTBC5FEC5176937CF9708C42EABAB","name":"EventoDiProva","creationDate":"2022-05-03 15:18:37"}
        EOF;

        $expectedMsg = <<<EOF
        Nel gestire il parsing di un evento AMQP in ingresso non e' stato possibile leggere la proprieta' obbligatoria "sender". L'array JSON di riferimento e' il seguente: {"id":"EVENTBC5FEC5176937CF9708C42EABAB","name":"EventoDiProva","creationDate":"2022-05-03 15:18:37"}
        EOF;

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage($expectedMsg);
        new InboundEventJson($jsonEvent);
    }

    /**
     * Verifica creazione evneto JSON in ingresso senza data creazione
     */
    public function testCreationWithoutCreationDate()
    {
        $jsonEvent = <<<EOF
        {"id":"EVENTBC5FEC5176937CF9708C42EABAB","name":"EventoDiProva","sender":"Mikro"}
        EOF;

        $expectedMsg = <<<EOF
        Nel gestire il parsing di un evento AMQP in ingresso non e' stato possibile leggere la proprieta' obbligatoria "creationDate". L'array JSON di riferimento e' il seguente: {"id":"EVENTBC5FEC5176937CF9708C42EABAB","name":"EventoDiProva","sender":"Mikro"}
        EOF;

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage($expectedMsg);
        new InboundEventJson($jsonEvent);
    }

    /**
     * Verifica creazione evneto JSON in ingresso con data creazione non formattata bene
     */
    public function testCreationBadCreationDate()
    {
        $jsonEvent = <<<EOF
        {"id":"EVENTBC5FEC5176937CF9708C42EABAB","name":"EventoDiProva","sender":"Mikro","creationDate":"2022-05-01"}
        EOF;

        $expectedMsg = <<<EOF
        Nel gestire il parsing di un evento AMQP in ingresso non e' stato possibile estrarre correttamente il valore della proprieta' "creationDate". Il formato previsto e' definito dalla costante EVENT_DATE_TIME_FORMAT che corrisponde a "%s". Il valore estratto dal contenuto dell'evento e' "2022-05-01".
        EOF;
        $expectedMsg = sprintf($expectedMsg, EVENT_DATE_TIME_FORMAT);

        $this->expectException(NotValidException::class);
        $this->expectExceptionMessage($expectedMsg);
        new InboundEventJson($jsonEvent);
    }
}
