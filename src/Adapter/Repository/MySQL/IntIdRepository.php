<?php

/**
 * IntIdRepository.php
 * Mikro\Adapter\Repository\MySQL\IntIdRepository
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Adapter\Repository\MySQL;

use Mikro\Adapter\Repository\MySQL\RepositoryAbstract;
use Mikro\Repository\IntIdRepositoryInterface;
use Mikro\Entity\EntityInterface;
use Mikro\Common\SQL\Connection\ConnectionInterface;

/**
 * Implementazione astratta MySQL repository di tipo indice intero
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class IntIdRepository extends RepositoryAbstract implements IntIdRepositoryInterface
{
    /**
     * Nome field identificativo entità
     *
     * @var ?string $idName Nome field
     */
    private ?string $idName = null;

    /**
     * Costruttore
     *
     * @param ConnectionInterface $conn Istanza connessione MySQL\ConnectionInterface
     * @param EntityInterface $entity Istanza entità oggetto del repository
     * @param string $tableName Nome tabella di riferimento
     * @param string $idName Nome proprietà/field identificativo entità
     *
     * @return void
     */
    public function __construct(ConnectionInterface $conn, EntityInterface $entity, string $tableName, string $idName)
    {
        parent::__construct($conn, $entity, $tableName);
        $this->idName = $idName;
    }

    /**
     * Recupero singola entità dato identificativo univoco
     *
     * @param int $id Identificativo univoco entità
     *
     * @return ?EntityInterface
     */
    public function findById(int $id): ?EntityInterface
    {
        $query = [];
        $query[] = sprintf('SELECT * FROM `%s`', $this->tableName);
        $query[] = 'WHERE';
        $query[] = sprintf('`%s` = :id', $this->idName);
        $query = implode(' ', $query);
        $result = $this->getRow($query, ['id' => $id]);
        return is_null($result) ? null : $this->arrayToEntity($result);
    }

    /**
     * Cancellazione singola entità dato identificativo univoco
     *
     * @param int $id Identificativo univoco entità
     *
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        $query = [];
        $query[] = sprintf('DELETE FROM `%s`', $this->tableName);
        $query[] = 'WHERE';
        $query[] = sprintf('`%s` = :id', $this->idName);
        $query = implode(' ', $query);
        $result = $this->getRow($query, ['id' => $id]);
        return is_null($this->findById($id));
    }

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
    abstract public function save(EntityInterface $entity): EntityInterface;

    /**
     * Generazione stringa politica di raggruppamento per univocità subset query di ricerca
     *
     * Una query MySQL non può organizzare e quindi ordinare risultati riferendosi ad una colonna
     * derivante da una join quando si usa l'operatore DISTINCT. Per questo motivo si rende
     * imprescindibile l'utilizzo dei GROUP BY. In questo modo la query saprà come rendere univoci
     * i risultati, semplicemente forzando un raggruppamento per chiavi.
     *
     * Dato che le chiavi di riferimento della tabella oggetto d'istanza verranno definite nella
     * prossima implementazione astratta, verrà implementato li questo metodo.
     *
     * @return string
     */
    protected function getGroupingStringPolicy(): string
    {
        return sprintf('GROUP BY `%s`.`%s`', $this->tableName, $this->idName);
    }

    /**
     * Costruzione entità dato array di dati
     *
     * @param array $array Fetch riga database
     *
     * @return EntityInterface
     */
    abstract protected function arrayToEntity(array $array = []): EntityInterface;
}
