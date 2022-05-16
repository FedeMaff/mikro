<?php

/**
 * OutboundEventAbstract.php
 * Mikro\Event\OutboundEventAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Event;

use Mikro\Event\EventAbstract;
use Mikro\Settings;
use Mikro\Exceptions\NotFoundException;
use Mikro\Exceptions\ConstantException;
use DateTime;

/**
 * Implementazione astratta evento in uscita
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class OutboundEventAbstract extends EventAbstract
{
    /**
     * Costruttore
     *
     * @param string $name Nome evento
     * @param array $data Array associativo dati
     * @param ?string $referenceId Identificativo univoco evento di riferimento
     * @param ?int $expiresIn Secondi di validità da data di creazione
     */
    public function __construct(string $name, array $data = [], ?string $referenceId = null, ?int $expiresIn = null)
    {
        parent::__construct(
            $this->getUniqueId(),
            $name,
            Settings::getServiceName(),
            new DateTime(),
            $data,
            $referenceId,
            $expiresIn
        );
    }

    /**
     * Recupero identificativo univoco
     *
     * @return string
     */
    private function getUniqueId(): string
    {
        $length = EVENT_ID_LENGTH - strlen(EVENT_ID_PREFIX);

        if ($length < 15) {
            $message[] = 'La lunghezza della chiave univa e\' troppo limitata.';
            $message[] = 'La differenza tra EVENT_ID_LENGTH e la lunghezza del valore della costante';
            $message[] = 'EVENT_ID_PREFIX non supera i 15 caratteri. Aumenta il valore di EVENT_ID_LENGTH';
            $message[] = 'o riduci la lunghezza di caratteri della costante EVENT_ID_PREFIX.';
            $message = implode(' ', $message);
            throw new ConstantException($message);
        }

        $token = null;

        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
            $token = substr(bin2hex($bytes), 0, $length);
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
            $token = substr(bin2hex($bytes), 0, $length);
        }

        if (is_null($token)) {
            $message[] = 'E\' stato impossibile generare un identificativo univoco per l\'evento';
            $message[] = 'in uscita. E\' necessario verificare che almeno una delle seguenti';
            $message[] = 'funzionalita\' sia abilitata: "random_bytes" o "openssl_random_pseudo_bytes".';
            $message = implode(' ', $message);
            throw new NotFoundException($message);
        }

        return strtoupper(sprintf('%s%s', EVENT_ID_PREFIX, $token));
    }
}
