<?php

/**
 * EntityResponse.php
 * Mikro\Response\EntityResponse
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
use Mikro\Entity\EntityInterface;
use Mikro\Tools\OutputDecorator;

/**
 * Implementazione concreta risposta formato Oggetto Entità
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class EntityResponse extends FormattableResponseAbstract
{
    /**
     * Istanza Entità
     *
     * @var ?EntityInterface $entity Istanza EntityInterface
     */
    private ?EntityInterface $entity = null;

    /**
     * Costruttore
     *
     * @param EntityInterface $entity Istanza EntityInterface
     * @param FormatterInterface $formatter Istanza formattatore
     */
    public function __construct(EntityInterface $entity, FormatterInterface $formatter)
    {
        $this->entity = $entity;
        parent::__construct($formatter);
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        $string = $this->formatter->entityToString($this->entity);
        return OutputDecorator::decorate($string);
    }
}
