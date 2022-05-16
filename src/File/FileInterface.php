<?php

/**
 * FileInterface.php
 * Mikro\File\FileInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\File;

/**
 * Interfaccia generica file
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface FileInterface
{
    /**
     * Recupero percorso file
     *
     * @return string
     */
    public function getPath(): string;
}
