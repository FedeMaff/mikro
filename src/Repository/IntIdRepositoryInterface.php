<?php

/**
 * IntIdRepositoryInterface.php
 * Mikro\Repository\IntIdRepositoryInterface
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
 * Interfaccia repository / archivio con identificativo intero
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface IntIdRepositoryInterface extends RepositoryInterface
{
    /**
     * Recupero singola entità dato identificativo univoco
     *
     * @param int $id Identificativo univoco entità
     *
     * @return ?EntityInterface
     */
    public function findById(int $id): ?EntityInterface;

    /**
     * Cancellazione singola entità dato identificativo univoco
     *
     * @param int $id Identificativo univoco entità
     *
     * @return bool
     */
    public function deleteById(int $id): bool;
}
