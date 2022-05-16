<?php

/**
 * ModelAbstract.php
 * Mikro\Model\ModelAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Model;

use Mikro\Repository\RepositoryInterface;

/**
 * Implementazione astratta modello business logic
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class ModelAbstract implements ModelInterface
{
    /**
     * Istanza repository di riferimento
     *
     * @var ?RepositoryInterface $repository Istanza repository
     */
    protected ?RepositoryInterface $repository = null;

    /**
     * Costruttore
     *
     * @param ?RepositoryInterface $repository Istanza repository
     */
    public function __construct(?RepositoryInterface $repository = null)
    {
        $this->repository = $repository;
    }
}
