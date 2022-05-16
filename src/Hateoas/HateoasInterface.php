<?php

/**
 * HateoasInterface.php
 * Mikro\Hateoas\HateoasInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Hateoas;

/**
 * Interfaccia generica serializzatore HATEOAS
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface HateoasInterface
{
    /**
     * Assegnazione elenco termini di contesto
     * Hatoas può offrire un sistema di "taglio" di proprietà organizzato
     * su un sistema di keywords specifiche. Grazie a dei termini di riferimento
     * il builder hatoas deve essere in grado di rimuovere dall'output finale
     * alcune proprietà per snellire le rappresentazioni delle risorse.
     *
     * @param array $array Elenco parole di contesto
     *
     * @return void
     */
    public function setContextTerms(array $array = []): void;

    /**
     * Conversione array/oggetto/istanza in stringa HATEOAS
     *
     * @param data $data Array / Object / Istanza di classe
     *
     * @return string
     */
    public function serialize($data, string $format): string;
}
