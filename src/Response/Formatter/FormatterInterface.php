<?php

/**
 * FormatterInterface.php
 * Mikro\Response\Formatter\FormatterInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response\Formatter;

use Mikro\Entity\EntityInterface;
use Mikro\EntityCollection\EntityCollectionInterface;
use Exception;

/**
 * Interfaccia generica formattatore di elementi di risposta
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface FormatterInterface
{
    /**
     * Recupero tipo formato generico
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Recupero content/mime type del tipo di formattazione
     *
     * @return string
     */
    public function getContentType(): string;

    /**
     * Conversione oggetto in stringa
     *
     * @param object $object Oggetto generico
     *
     * @return string
     */
    public function objectToString(object $object): string;

    /**
     * Conversione entità in stringa
     *
     * @param EntityInterface $entity Istanza entità
     *
     * @return string
     */
    public function entityToString(EntityInterface $entity): string;

    /**
     * Conversione collezione di entità in stringa
     *
     * @param EntityCollectionInterface $entityCollection Istanza elenco entità
     *
     * @return string
     */
    public function entityCollectionToString(EntityCollectionInterface $entityCollection): string;

    /**
     * Conversione eccezione in stringa
     *
     * @param Exception $exception Istanza eccezione
     *
     * @return string
     */
    public function exceptionToString(Exception $exception): string;
}
