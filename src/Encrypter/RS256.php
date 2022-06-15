<?php

/**
 * RS256.php
 * Mikro\Encrypter\RS256
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
 * Implementazione concreta criptatore asimmetrico RS256
 *
 * Per generare una coppia di chiavi valide per questo algoritmo
 * è possibile utilizzare i seguenti comando:
 *
 * $ ssh-keygen -q -t rsa -b 4096 -m PEM -f id.key -N ""
 * $ openssl rsa -in id.key -pubout -outform PEM -out id.key.pub
 *
 * Si consiglia di non storare mai chiavi di questo tipo nel codice
 * sorgente, piuttosto utilizza le variabili d'ambiente del sistema
 * di CI/CD.
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class RS256 extends EncrypterAbstract
{
    /**
     * Chiave di criptazione
     *
     * @var string $privateKey Chiave di criptazione
     */
    private string $privateKey = '';

    /**
     * Chiave di decriptazione
     *
     * @var string $publicKey Chiave di decriptazione
     */
    private string $publicKey = '';

    /**
     * Costruttore
     *
     * @param string $privateKey Chiave di criptazione
     * @param string $publicKey Chiave di decriptazione
     */
    public function __construct(string $privateKey, string $publicKey)
    {
        parent::__construct('RS256');
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    /**
     * Recupero chiave di codifica
     *
     * @return string
     */
    public function getEncodeKey(): string
    {
        return $this->privateKey;
    }

    /**
     * Recupero chiave di decodifica
     *
     * @return string
     */
    public function getDecodeKey(): string
    {
        return $this->publicKey;
    }
}
