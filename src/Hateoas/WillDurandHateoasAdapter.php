<?php

/**
 * WillDurandHateoasAdapter.php
 * Mikro\Hateoas\WillDurandHateoasAdapter
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Hateoas;

use Mikro\Hateoas\HateoasInterface;
use Hateoas\Hateoas;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\ContextFactory\DefaultSerializationContextFactory as ContextFactory;

/**
 * Adattatore dedicato al serializzatore HATOAS di Will Durand
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class WillDurandHateoasAdapter implements HateoasInterface
{
    /**
     * Istanza serializzatore HATEOAS di Will Durand
     *
     * @var ?Hateoas $hateoas Istanza Hateoas
     */
    private ?Hateoas $hateoas = null;

    /**
     * Istanza contesto di serializzazione
     *
     * @var ?SerializationContext $context Istanza SerializationContext
     */
    private ?SerializationContext $context = null;

    /**
     * Costruttore
     *
     * @var Hateoas $hateoas Istanza Hateoas
     */
    public function __construct(Hateoas $hateoas = null)
    {
        $this->hateoas = $hateoas;
    }

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
    public function setContextTerms(array $array = []): void
    {
        $this->context = null;
        $this->context = (new ContextFactory())->createSerializationContext();
        $this->context->setGroups($array);
    }

    /**
     * Conversione array/oggetto/istanza in stringa HATEOAS
     *
     * @param data $data Array / Object / Istanza di classe
     *
     * @return string
     */
    public function serialize($data, string $format): string
    {
        return $this->hateoas->serialize($data, $format, $this->context);
    }
}
