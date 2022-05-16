<?php

/**
 * JsonFormatter.php
 * Mikro\Response\Formatter\JsonFormatter
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response\Formatter;

use Mikro\Response\Formatter\FormatterInterface;
use Mikro\Entity\EntityInterface;
use Mikro\EntityCollection\EntityCollectionInterface;
use Mikro\Factory\HateoasFactory;
use Exception;

/**
 * Implementazione concreta formattatore di elementi di risposta JSON
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class JsonFormatter implements FormatterInterface
{
    /**
     * Recupero tipo formato generico
     *
     * @return string
     */
    public function getType(): string
    {
        return TYPE_JSON;
    }

    /**
     * Recupero content/mime type del tipo di formattazione
     *
     * @return string
     */
    public function getContentType(): string
    {
        return 'application/json';
    }

    /**
     * Conversione oggetto in stringa
     *
     * @param object $object Oggetto generico
     *
     * @return string
     */
    public function objectToString(object $object): string
    {
        $hateoas = HateoasFactory::create();
        return $hateoas->serialize($object, TYPE_JSON);
    }

    /**
     * Conversione entità in stringa
     *
     * @param EntityInterface $entity Istanza entità
     *
     * @return string
     */
    public function entityToString(EntityInterface $entity): string
    {
        $hateoas = HateoasFactory::create();
        return $hateoas->serialize($entity, TYPE_JSON);
    }

    /**
     * Conversione collezione di entità in stringa
     *
     * @param EntityCollectionInterface $entityCollection Istanza elenco entità
     *
     * @return string
     */
    public function entityCollectionToString(EntityCollectionInterface $entityCollection): string
    {
        $hateoas = HateoasFactory::create();
        return $hateoas->serialize($entityCollection, TYPE_JSON);
    }

    /**
     * Conversione eccezione in stringa
     *
     * @param Exception $exception Istanza eccezione
     *
     * @return string
     */
    public function exceptionToString(Exception $exception): string
    {
        $hateoas = HateoasFactory::create();
        return $hateoas->serialize($exception, TYPE_JSON);
    }
}
