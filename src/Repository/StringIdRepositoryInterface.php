<?php

/**
 * StringIdRepositoryInterface.php
 * Mikro\Repository\StringIdRepositoryInterface
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

/**
 * Interfaccia repository / archivio con identificativo stringa
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface StringIdRepositoryInterface extends RepositoryInterface
{
    /**
     * Recupero singola entità dato identificativo univoco
     *
     * @param string $id Identificativo univoco entità
     *
     * @return ?EntityInterface
     */
    public function findById(string $id): ?EntityInterface;

    /**
     * Cancellazione singola entità dato identificativo univoco
     *
     * @param string $id Identificativo univoco entità
     *
     * @return bool
     */
    public function deleteById(string $id): bool;
}
