<?php

/**
 * HS256.php
 * Mikro\Encrypter\HS256
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Encrypter;

use Mikro\Encrypter\EncrypterAbstract;

/**
 * Implementazione concreta criptatore simmetrico HS256
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class HS256 extends EncrypterAbstract
{
    /**
     * Chiave di criptazione e decriptazione
     *
     * @var string $key Chiave di criptazione e decriptazione
     */
    private string $key = '';

    /**
     * Costruttore
     *
     * @param string $key Chiave di criptazione e decriptazione
     */
    public function __construct(string $key)
    {
        parent::__construct('HS256');
        $this->key = $key;
    }

    /**
     * Recupero chiave di codifica
     *
     * @return string
     */
    public function getEncodeKey(): string
    {
        return $this->key;
    }

    /**
     * Recupero chiave di decodifica
     *
     * @return string
     */
    public function getDecodeKey(): string
    {
        return $this->key;
    }
}
