<?php

/**
 * EncrypterAbstract.php
 * Mikro\Encrypter\EncrypterAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Encrypter;

use Mikro\Encrypter\EncrypterInterface;

/**
 * Implementazione astratta classe di criptazione generica
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class EncrypterAbstract implements EncrypterInterface
{
    /**
     * Algoritmo di criptazione
     *
     * @var string $alg Alogritmo di criptazione
     */
    private string $alg = '';

    /**
     * Costruttore
     *
     * @param string $alg Alogritmo di criptazione
     */
    public function __construct(string $alg)
    {
        $this->alg = $alg;
    }

    /**
     * Recupero chiave di codifica
     *
     * @return string
     */
    abstract public function getEncodeKey(): string;

    /**
     * Recupero chiave di decodifica
     *
     * @return string
     */
    abstract public function getDecodeKey(): string;

    /**
     * Recupero codice algoritmo di criptazione
     *
     * @return string
     */
    public function getAlg(): string
    {
        return $this->alg;
    }
}
