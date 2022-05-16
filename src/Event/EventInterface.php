<?php

/**
 * EventInterface.php
 * Mikro\Event\EventInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event;

use DateTime;

/**
 * Interfaccia evento
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface EventInterface
{
    /**
     * Recupero identificativo univoco evento
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Recupero nome componente applicativa mittente
     *
     * @return string
     */
    public function getSender(): string;

    /**
     * Recupero nome evento
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Recupero data creazione
     *
     * @return DateTime
     */
    public function getCreationDate(): DateTime;

    /**
     * Recupero array associativo dati
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Recupero identificativo univoco evento di riferimento
     *
     * @return ?string
     */
    public function getReferenceId(): ?string;

    /**
     * Recupero secondi di validità da data di creazione
     *
     * @return ?int
     */
    public function getExpiresIn(): ?int;
}
