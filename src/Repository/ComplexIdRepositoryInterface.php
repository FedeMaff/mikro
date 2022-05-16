<?php

/**
 * ComplexIdRepositoryInterface.php
 * Mikro\Repository\ComplexIdRepositoryInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository;

use Mikro\Entity\EntityInterface;
use Mikro\Repository\RepositoryInterface;
use Mikro\Repository\ComplexIdInterface;

/**
 * Interfaccia repository / archivio con identificativo a più chiavi
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ComplexIdRepositoryInterface extends RepositoryInterface
{
    /**
     * Recupero singola entità dato identificativo univoco
     *
     * @param ComplexIdInterface $id Identificativo univoco entità
     *
     * @return ?EntityInterface
     */
    public function findById(ComplexIdInterface $id): ?EntityInterface;

    /**
     * Cancellazione singola entità dato identificativo univoco
     *
     * @param ComplexIdInterface $id Identificativo univoco entità
     *
     * @return bool
     */
    public function deleteById(ComplexIdInterface $id): bool;
}
