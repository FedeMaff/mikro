<?php

/**
 * RepositoryInterface.php
 * Mikro\Repository\RepositoryInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository;

use Mikro\Entity\EntityInterface;
use Mikro\EntityCollection\EntityCollectionInterface;
use Mikro\Repository\Criteria\CriteriaInterface;

/**
 * Interfaccia generica repository / archivio
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * Salvataggio / Aggiornamento entità
     *
     * Questo metodo scriverà la nuova entità sul volume persistente restituendo
     * valorizzati eventuali chiavi "id" dell'entità. Oppure nel caso in cui
     * l'identificativo univoco sia già valorizzato questo metodo aggiornerà con
     * le nuove informazioni l'entità sul volume persistente.
     *
     * @param EntityInterface $entity Istanza entità
     *
     * @return EntityInterface
     */
    public function save(EntityInterface $entity): EntityInterface;

    /**
     * Ricerca singola entità
     *
     * @param ?CriteriaInterface $criteria Istanza criteri di lettura
     *
     * @return ?EntityInterface
     */
    public function find(?CriteriaInterface $criteria = null): ?EntityInterface;

    /**
     * Ricerca elenco etità
     *
     * @param ?CriteriaInterface $criteria Istanza criteri di lettura
     *
     * @return EntityCollectionInterface
     */
    public function findAll(?CriteriaInterface $criteria = null): EntityCollectionInterface;
}
