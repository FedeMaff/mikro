<?php

/**
 * EncrypterInterface.php
 * Mikro\Encrypter\EncrypterInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Encrypter;

/**
 * Interfaccia classe di criptazione generica
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface EncrypterInterface
{
    /**
     * Recupero chiave di codifica
     *
     * @return string
     */
    public function getEncodeKey(): string;

    /**
     * Recupero chiave di decodifica
     *
     * @return string
     */
    public function getDecodeKey(): string;

    /**
     * Recupero codice algoritmo di criptazione
     *
     * @return string
     */
    public function getAlg(): string;
}
