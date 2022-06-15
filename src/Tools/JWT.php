<?php

/**
 * JWT.php
 * Mikro\Tools\JWT
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Tools;

use Mikro\Encrypter\EncrypterInterface;
use Mikro\Exceptions\UnauthorizedException;
use Mikro\Exceptions\NotAcceptableException;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key as FirebaseKey;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DateTime;
use DateInterval;

/**
 * Classe manager di token JWT
 * Questa implementazione concreta permette di generare token JWT e di
 * recuperarne il payload. Questa classe è un wrapper dell'implementazione
 * dello standard JWT offerto da "firebase".
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class JWT
{
    /**
     * Encodiing Payload (array) in JWT
     *
     * @param array $payload Array associativo dati custom
     * @param EncrypterInterface $encrypter Istanza Criptatore
     * @param int $expiration Numero di minuti di validità
     *
     * @return string
     */
    public static function encode(
        array $payload,
        EncrypterInterface $encrypter,
        ?int $expiration = null
    ): string {

        $now = new DateTime();
        $payload['iat'] = $now->getTimestamp();

        if (!is_null($expiration)) {
            $now->add(new DateInterval(sprintf('PT%sM', $expiration)));
            $payload['exp'] = $now->getTimestamp();
        }

        $encryptKey = $encrypter->getEncodeKey();
        $alg = $encrypter->getAlg();

        return FirebaseJWT::encode($payload, $encryptKey, $alg);
    }

    /**
     * Parsing JWT in Payload
     *
     * @param string $jwt Token JWT
     * @param EncrypterInterface $encrypter Istanza Criptatore
     *
     * @return array
     */
    public static function decode(
        string $jwt,
        EncrypterInterface $encrypter
    ): array {

        $decryptKey = $encrypter->getDecodeKey();
        $alg = $encrypter->getAlg();

        try {
            $payload = FirebaseJWT::decode($jwt, new FirebaseKey($decryptKey, $alg));
        } catch (\ExpiredException $e) {
            self::throwExpiredException();
        } catch (\BeforeValidException $e) {
            self::throwBeforeValidException();
        } catch (\Exception $e) {
            print_r($e->getMessage());
            self::throwInvalidException();
        }

        return (array)$payload;
    }

    /**
     * Avvio eccezione UnauthorizedException
     * Derivante da token JWT scaduto
     *
     * @return void
     */
    private static function throwExpiredException(): void
    {
        $message[] = 'Nel processo di verifica del token il sistema ha rilevato';
        $message[] = 'che la stringa alfanumerica e\' formalmente valida tuttavia';
        $message[] = 'il token JWT e\' scaduto di conseguenza la richiesta non';
        $message[] = 'e\' stata autorizzata.';
        $message = implode(' ', $message);
        throw new UnauthorizedException($message);
    }

    /**
     * Avvio eccezione NotAcceptableException
     * Derivante da token JWT non ancora in corso di validità
     *
     * @return void
     */
    private static function throwBeforeValidException(): void
    {
        $message[] = 'Nel processo di verifica del token il sistema ha rilevato';
        $message[] = 'che la stringa alfanumerica e\' formalmente valida tuttavia';
        $message[] = 'il token JWT non e\' ancora in corso di validita\' di';
        $message[] = 'conseguenza la richiesta non e\' stata accettata.';
        $message = implode(' ', $message);
        throw new NotAcceptableException($message);
    }

    /**
     * Avvio eccezione NotAcceptableException
     * Derivante da token JWT non valido (formalmente)
     *
     * @return void
     */
    private static function throwInvalidException(): void
    {
        $message[] = 'Nel processo di verifica del token il sistema ha rilevato';
        $message[] = 'che la stringa alfanumerica JWT non e\' formalmente valida';
        $message[] = 'di conseguenza la richiesta non e\' stata accettata.';
        $message = implode(' ', $message);
        throw new NotAcceptableException($message);
    }
}
