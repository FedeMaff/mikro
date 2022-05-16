<?php

/**
 * FormattableHttpResponseAbstract.php
 * Mikro\Response\FormattableHttpResponseAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\HttpResponseAbstract;
use Mikro\Response\Formatter\FormatterInterface;

/**
 * Implementazione astratta oggetto di risposta HTTP con formattatore
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class FormattableHttpResponseAbstract extends HttpResponseAbstract
{
    /**
     * Istanza formattatore
     *
     * @var ?FormatterInterface $formatter Istanza formattatore
     */
    protected ?FormatterInterface $formatter = null;

    /**
     * Costrutture
     *
     * @param int $code Codice stato HTTP
     * @param FormatterInterface $formatter Istanza formattatore
     *
     * @return void
     */
    public function __construct(int $code, FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
        parent::__construct($code);
    }

    /**
     * Assegnazione valori Headers di default
     * Metodo dedicato alla definizione degli headers di risposta.
     * Questi valori verranno direttamnete implementati nelle estensioni
     * concrete della classe in oggetto.
     *
     * @return void
     */
    protected function setHeaders(): void
    {
        parent::setHeaders();
        $contentType = $this->formatter->getContentType();
        $this->headers['Content-Type'] = "${contentType}; charset=utf-8";
    }
}
