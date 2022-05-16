<?php

/**
 * InboundEventJson.php
 * Mikro\Event\InboundEventJson
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event;

use Mikro\Event\InboundEventAbstract;
use Mikro\Exceptions\JsonStringException;
use Mikro\Exceptions\NotFoundException;
use Mikro\Exceptions\NotValidException;
use DateTime;

/**
 * Implementazione concreta evento in ingresso in formato "JSON"
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class InboundEventJson extends InboundEventAbstract
{
    /**
     * Costruttore
     *
     * @param string $jsonString Stringa JSON
     */
    public function __construct(string $jsonString)
    {
        $jsonArray = json_decode($jsonString, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            $this->throwJsonStringException($jsonString);
        }

        $id = $this->parseEventId($jsonArray);
        $name = $this->parseEventName($jsonArray);
        $sender = $this->parseEventSender($jsonArray);
        $creationDate = $this->parseEventCreationDate($jsonArray);
        $data = $this->parseEventData($jsonArray);
        $referenceId = $this->parseEventReferenceId($jsonArray);
        $expiresIn = $this->parseEventExpiresIn($jsonArray);

        parent::__construct(
            $id,
            $name,
            $sender,
            $creationDate,
            $data,
            $referenceId,
            $expiresIn
        );
    }

    /**
     * Avvio eccezione JsonStringException
     *
     * @param string $json Stringa JSON non valida
     *
     * @return void
     */
    protected function throwJsonStringException(string $json): void
    {
        $message[] = 'Nel gestire un evento AMQP in ingresso non e\' stato';
        $message[] = 'possibile decodificare in modo corretto il contenuto.';
        $message = implode(" ", $message);
        $exception = new JsonStringException($message);
        $exception->setJsonString($json);
        throw $exception;
    }

    /**
     * Recupero identificativo univoco evento
     *
     * @param array $jsonArray Oggetto JSON codificato in array
     *
     * @return void
     */
    protected function parseEventId(array $jsonArray): string
    {
        $id = isset($jsonArray['id']) ? (string)$jsonArray['id'] : null;
        if (is_null($id)) {
            $this->throwNotFoundException('id', $jsonArray);
        }
        return $id;
    }

    /**
     * Recupero nome evento
     *
     * @param array $jsonArray Oggetto JSON codificato in array
     *
     * @return void
     */
    protected function parseEventName(array $jsonArray): string
    {
        $name = isset($jsonArray['name']) ? (string)$jsonArray['name'] : null;
        if (is_null($name)) {
            $this->throwNotFoundException('name', $jsonArray);
        }
        return $name;
    }

    /**
     * Recupero nome servizio mittente
     *
     * @param array $jsonArray Oggetto JSON codificato in array
     *
     * @return string
     */
    protected function parseEventSender(array $jsonArray): string
    {
        $sender = isset($jsonArray['sender']) ? (string)$jsonArray['sender'] : null;
        if (is_null($sender)) {
            $this->throwNotFoundException('sender', $jsonArray);
        }
        return $sender;
    }

    /**
     * Recupero data di creazione dell'evento
     *
     * @param array $jsonArray Oggetto JSON codificato in array
     *
     * @return DateTime
     */
    protected function parseEventCreationDate(array $jsonArray): DateTime
    {
        $creationDate = isset($jsonArray['creationDate']) ? (string)$jsonArray['creationDate'] : null;
        if (is_null($creationDate)) {
            $this->throwNotFoundException('creationDate', $jsonArray);
        }
        $date = DateTime::createFromFormat(EVENT_DATE_TIME_FORMAT, $creationDate);
        if (!$date instanceof DateTime || $date->format(EVENT_DATE_TIME_FORMAT) != $creationDate) {
            $message[] = 'Nel gestire il parsing di un evento AMQP in ingresso non e\' stato';
            $message[] = 'possibile estrarre correttamente il valore della proprieta\' "creationDate".';
            $message[] = 'Il formato previsto e\' definito dalla costante EVENT_DATE_TIME_FORMAT';
            $message[] = sprintf('che corrisponde a "%s".', EVENT_DATE_TIME_FORMAT);
            $message[] = sprintf('Il valore estratto dal contenuto dell\'evento e\' "%s".', $creationDate);
            $message = implode(" ", $message);
            $exception = new NotValidException($message);
            throw $exception;
        }
        return $date;
    }

    /**
     * Recupero contenuto dati evento
     *
     * @param array $jsonArray Oggetto JSON codificato in array
     *
     * @return array
     */
    protected function parseEventData(array $jsonArray): array
    {
        $data = isset($jsonArray['data']) ? $jsonArray['data'] : null;
        if (is_array($data)) {
            return $data;
        }
        return [];
    }

    /**
     * Recupero identificativo univoco evento "parent" / di riferimento
     *
     * @param array $jsonArray Oggetto JSON codificato in array
     *
     * @return ?string
     */
    protected function parseEventReferenceId(array $jsonArray): ?string
    {
        $referenceId = isset($jsonArray['referenceId']) ? (string)$jsonArray['referenceId'] : null;
        return $referenceId;
    }

    /**
     * Recupero secondi di validità da data di creazione dell'evento
     *
     * @param array $jsonArray Oggetto JSON codificato in array
     *
     * @return ?int
     */
    protected function parseEventExpiresIn(array $jsonArray): ?int
    {
        $expiresIn = isset($jsonArray['expiresIn']) ? (int)$jsonArray['expiresIn'] : null;
        return $expiresIn;
    }

    /**
     * Avvio eccezione NotFoundException
     *
     * @param string $property Proprietà non torvata
     * @param array $jsonArray Array JSON di riferimento
     *
     * @return void
     */
    protected function throwNotFoundException(string $property, array $jsonArray): void
    {
        $jsonString = json_encode($jsonArray);
        $message[] = 'Nel gestire il parsing di un evento AMQP in ingresso non e\' stato';
        $message[] = sprintf('possibile leggere la proprieta\' obbligatoria "%s".', $property);
        $message[] = 'L\'array JSON di riferimento e\' il seguente:';
        $message[] = $jsonString;
        $message = implode(' ', $message);
        $exception = new NotFoundException($message);
        throw $exception;
    }
}
