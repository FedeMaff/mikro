<?php

/**
 * EntityHttpResponse.php
 * Mikro\Response\EntityHttpResponse
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
use Mikro\Entity\EntityInterface;
use Mikro\Tools\OutputDecorator;

/**
 * Implementazione concreta risposta HTTP di un Oggetto Entità
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class EntityHttpResponse extends FormattableHttpResponseAbstract
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
     * @param int $statusCode Codice stato http
     * @param FormatterInterface $formatter Istanza formattatore
     */
    public function __construct(EntityInterface $entity, int $statusCode, FormatterInterface $formatter)
    {
        $this->entity = $entity;
        parent::__construct($statusCode, $formatter);
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
