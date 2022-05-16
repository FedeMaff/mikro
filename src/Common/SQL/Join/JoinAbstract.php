<?php

/**
 * JoinAbstract.php
 * Mikro\Common\SQL\Join\JoinAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\SQL\Join;

use Mikro\Common\SQL\Join\JoinInterface;

/**
 * Implementazione astratta oggetto di configurazione join SQL
 *
 * Questa interfaccia astrae la sintassi SQL inerente il JOIN tra 2 tabelle.
 *
 * Verrà utilizzata all'interno di un metodo specifico nelle implementazioni
 * concrete di Mikro\Adapter\Repository\SQL\RepositoryAbstract.php
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class JoinAbstract implements JoinInterface
{
    /**
     * Nome tabella di partenza
     *
     * @var ?string $fromTable Nome tabella di partenza
     */
    private ?string $fromTable = null;

    /**
     * Nome field di partenza
     *
     * @var ?string $fromField Nome field di partenza
     */
    private ?string $fromField = null;

    /**
     * Nome tabella di destinazione
     *
     * @var ?string $toTable Nome tabella di destinazione
     */
    private ?string $toTable = null;

    /**
     * Nome field di destinazione
     *
     * @var ?string $toField Nome field di destinazione
     */
    private ?string $toField = null;

    /**
     * Costruttore
     *
     * @param string $fromTable Nome tabella di partenza
     * @param string $fromField Nome field di partenza
     * @param string $toTable Nome tabella di destinazione
     * @param string $toField Nome field di destinazione
     */
    public function __construct(
        string $fromTable,
        string $fromField,
        string $toTable,
        string $toField
    ) {
        $this->fromTable = $fromTable;
        $this->fromField = $fromField;
        $this->toTable = $toTable;
        $this->toField = $toField;
    }

    /**
     * Recupero nome tabella di partenza
     *
     * @return string
     */
    public function getFromTable(): string
    {
        return $this->fromTable;
    }

    /**
     * Recupero nome field di partenza
     *
     * @return string
     */
    public function getFromField(): string
    {
        return $this->fromField;
    }

    /**
     * Recupero nome tabella di destinazione
     *
     * @return string
     */
    public function getToTable(): string
    {
        return $this->toTable;
    }

    /**
     * Recupero nome field di destinazione
     *
     * @return string
     */
    public function getToField(): string
    {
        return $this->toField;
    }
}
