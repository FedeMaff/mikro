<?php

/**
 * EntityCollectionHttpResponse.php
 * Mikro\Response\EntityCollectionHttpResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\FormattableHttpResponseAbstract;
use Mikro\Response\Formatter\FormatterInterface;
use Mikro\EntityCollection\EntityCollectionInterface;

/**
 * Implementazione concreta risposta HTTP di un Oggetto Entità
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class EntityCollectionHttpResponse extends FormattableHttpResponseAbstract
{
    /**
     * Istanza collezione di entità
     *
     * @var ?EntityCollectionInterface $collection Istanza EntityCollectionInterface
     */
    private ?EntityCollectionInterface $collection = null;

    /**
     * Costruttore
     *
     * @param EntityCollectionInterface $collection Istanza EntityCollectionInterface
     * @param int $statusCode Codice stato http
     * @param FormatterInterface $formatter Istanza formattatore
     */
    public function __construct(EntityCollectionInterface $collection, int $statusCode, FormatterInterface $formatter)
    {
        $this->collection = $collection;
        parent::__construct($statusCode, $formatter);
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->formatter->entityCollectionToString($this->collection);
    }
}
