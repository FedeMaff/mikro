<?php

/**
 * FileResponseInterface.php
 * Mikro\Response\FileResponseInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\ResponseInterface;

/**
 * Interfaccia oggetto di gestione file response
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface FileResponseInterface extends ResponseInterface
{
    /**
     * Recupero percorso file
     *
     * @return string
     */
    public function getFilePath(): string;
}
