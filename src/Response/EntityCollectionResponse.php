<?php

/**
 * EntityCollectionResponse.php
 * Mikro\Response\EntityCollectionResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\FormattableResponseAbstract;
use Mikro\Response\Formatter\FormatterInterface;
use Mikro\EntityCollection\EntityCollectionInterface;
use Mikro\Tools\OutputDecorator;

/**
 * Implementazione concreta risposta HTTP di un Oggetto Entità
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class EntityCollectionResponse extends FormattableResponseAbstract
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
     * @param FormatterInterface $formatter Istanza formattatore
     */
    public function __construct(EntityCollectionInterface $collection, FormatterInterface $formatter)
    {
        $this->collection = $collection;
        parent::__construct($formatter);
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        $string = $this->formatter->entityCollectionToString($this->collection);
        return OutputDecorator::decorate($string);
    }
}
