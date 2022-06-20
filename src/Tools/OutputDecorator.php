<?php

/**
 * OutputDecorator.php
 * Mikro\Tools\OutputDecorator
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Tools;

/**
 * Questa classe concreta viene utilizzata dai response strutturati che
 * fanno uso di formatter. Permette di elaborare ulteriormente il risultato
 * finale della parsificazione. Grazie a questa classe sarà quindi possibile
 * sostituire qualsiasi tipo di valore all'interno della stringa di risposta.
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class OutputDecorator
{
    /**
     * Metodo di parsificazione stringa di risposta
     *
     * @param ?string $string Stringa output response
     *
     * @return ?string
     */
    public static function decorate(?string $string = null): ?string
    {
        if (is_null($string) || DECORATE_OUTPUT !== true) {
            return $string;
        }

        $string = static::decorateConstants($string);

        return $string;
    }

    /**
     * Avvio sostituzione costanti utente
     *
     * @param string $string Stringa output response
     *
     * @return string
     */
    protected static function decorateConstants(string $string): string
    {
        $constants = get_defined_constants(true);
        $constants = isset($constants['user']) ? $constants['user'] : [];
        $keys = array_keys($constants);
        $values = array_values($constants);
        foreach ($keys as &$key) {
            $key = static::toSelector($key);
        }

        return str_replace($keys, $values, $string);
    }

    /**
     * Trasformazione stringa nome proprietà in selettore nome proprietà
     *
     * @param string $propertyName Stringa contenente il nome di una proprietà
     */
    final protected static function toSelector(string $propertyName): string
    {
        return sprintf('%s%s%s', DECORATOR_PREFIX, $propertyName, DECORATOR_SUFFIX);
    }
}
