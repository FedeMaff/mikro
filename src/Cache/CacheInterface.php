<?php

/**
 * CacheInterface.php
 * Mikro\Cache\CacheInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Cache;

/**
 * Interfaccia generica cache
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface CacheInterface
{
    /**
     * Recupero contenuto da cache
     *
     * @param string $reference Identificativo di riferimento
     *
     * @return ?string
     */
    public function read(string $reference): ?string;

    /**
     * Scrittura contenuto in cache
     *
     * @param string $reference Identificativo di riferimento
     * @param string $content Contenuto
     *
     * @return void
     */
    public function write(string $reference, string $content): void;
}
