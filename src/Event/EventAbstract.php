<?php

/**
 * EventAbstract.php
 * Mikro\Event\EventAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event;

use Mikro\Event\EventInterface;
use DateTime;

/**
 * Implementazione astratta evento generico
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class EventAbstract implements EventInterface
{
    /**
     * Identificativo univoco evento
     *
     * @var ?string $id Identificativo univoco evento
     */
    private ?string $id = null;

    /**
     * Nome evento
     *
     * @var ?string $name Nome univoco evento
     */
    private ?string $name = null;

    /**
     * Nome componente applicativa mittente
     *
     * @var ?string $sender Nome componente applicativa mittente
     */
    private ?string $sender = null;

    /**
     * Data creazione evento
     *
     * @var ?DateTime Data creazione evento
     */
    private ?DateTime $creationDate = null;

    /**
     * Array associativo dati
     *
     * @var array $data Array associativo dati
     */
    private array $data = [];

    /**
     * Identificativo univoco evento di riferimento
     *
     * @var ?string $referenceId Identificativo univoco evento di riferimento
     */
    private ?string $referenceId = null;

    /**
     * Secondi di validità da data di creazione
     *
     * @var ?int $expiresIn Secondi di validità da data di creazione
     */
    private ?int $expiresIn = null;

    /**
     * Costruttore
     *
     * @param string $id Identificativo univoco evento
     * @param string $name Nome univoco evento
     * @param string $sender Nome componente applicativa mittente
     * @param DateTime Data creazione evento
     * @param ?int $expiresIn Secondi di validità da data di creazione
     * @param ?string $referenceId Identificativo univoco evento di riferimento
     * @param array $data Array associativo dati
     */
    public function __construct(
        string $id,
        string $name,
        string $sender,
        DateTime $creationDate,
        ?array $data = [],
        ?string $referenceId = null,
        ?int $expiresIn = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->sender = $sender;
        $this->creationDate = $creationDate;
        $this->data = $data;
        $this->referenceId = $referenceId;
        $this->expiresIn = $expiresIn;
    }

    /**
     * Recupero identificativo univoco evento
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Recupero nome componente applicativa mittente
     *
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * Recupero nome evento
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Recupero data creazione
     *
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * Recupero array associativo dati
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Recupero identificativo univoco evento di riferimento
     *
     * @return ?string
     */
    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    /**
     * Recupero secondi di validità da data di creazione
     *
     * @return ?int
     */
    public function getExpiresIn(): ?int
    {
        return $this->expiresIn;
    }

    /**
     * Recupero flag scaduto
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        if (is_null($this->expiresIn)) {
            return false;
        }
        $expirationDate = DateTime::createFromFormat('U', $this->creationDate->format('U'));
        $interval = new \DateInterval(sprintf('PT0H%sS', abs($this->expiresIn)));
        $method = ($this->expiresIn < 0) ? 'sub' : 'add';
        $expirationDate->{$method}($interval);
        return $expirationDate->format('U') < (new DateTime())->format('U');
    }

    /**
     * Stampa evento in formato stringa
     *
     * @return string
     */
    public function __toString(): string
    {
        $array = [];
        $array['id'] = $this->id;
        $array['name'] = $this->name;
        $array['sender'] = $this->sender;
        $creationDate = ($this->creationDate instanceof DateTime) ? $this->creationDate : null;
        $array['creationDate'] = is_null($creationDate) ? null : $creationDate->format(EVENT_DATE_TIME_FORMAT);
        if (!empty($this->data)) {
            $array['data'] = $this->data;
        }
        $referenceId = $this->referenceId;
        if (!is_null($referenceId)) {
            $array['referenceId'] = $referenceId;
        }
        $expiresIn = $this->expiresIn;
        if (!is_null($expiresIn)) {
            $array['expiresIn'] = $expiresIn;
        }
        return json_encode($array);
    }
}
