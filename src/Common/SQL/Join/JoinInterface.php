<?php

/**
 * JoinInterface.php
 * Mikro\Common\SQL\Join\JoinInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Common\SQL\Join;

/**
 * Interfaccia di configurazione join SQL
 *
 * Questa interfaccia astrae la sintassi SQL inerente il JOIN tra 2 tabelle.
 *
 * Verrà utilizzata all'interno di un metodo specifico nelle implementazioni
 * concrete di Mikro\Adapter\Repository\SQL\RepositoryAbstract.php
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface JoinInterface
{
    /**
     * Recupero nome tabella di partenza
     *
     * @return string
     */
    public function getFromTable(): string;

    /**
     * Recupero nome field di partenza
     *
     * @return string
     */
    public function getFromField(): string;

    /**
     * Recupero nome tabella di partenza
     *
     * @return string
     */
    public function getToTable(): string;

    /**
     * Recupero nome field di partenza
     *
     * @return string
     */
    public function getToField(): string;
}
