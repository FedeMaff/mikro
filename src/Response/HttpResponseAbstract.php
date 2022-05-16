<?php

/**
 * HttpResponseAbstract.php
 * Mikro\Response\HttpResponseAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\HttpResponseInterface;
use Mikro\Response\ResponseAbstract;

/**
 * Implementazione astratta oggetto di risposta HTTP
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class HttpResponseAbstract implements HttpResponseInterface
{
    /**
     * Codice di stato risposta
     *
     * @var ?int $statusCode Codice di risposta http
     */
    protected ?int $statusCode = null;

    /**
     * Frase descrittiva di accompagnamento
     *
     * @var ?string $reasonPhrase Frase descrittiva di accompagnamento
     */
    protected ?string $reasonPhrase = null;

    /**
     * Elenco chiave/valore proprietà di header
     *
     * @var array $headers Elenco chiave/valore proprietà di header
     */
    protected array $headers = [];

    /**
     * Costrutture
     *
     * @param int $statusCode Codice stato HTTP
     *
     * @return void
     */
    public function __construct(int $statusCode)
    {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $this->getReasonPhraseByStatusCode($statusCode);
        $this->setHeaders();
    }

    /**
     * Recupero codice di stato risposta
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Recupero frase descrittiva di accompagnamento al codice di stato risposta
     *
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * Recupero elenco chiave/valore proprietà di header
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }

    /**
     * Recupero frase descrittiva di accompagnamento dato il codice di stato
     *
     * @param int $statusCode Codice di stato risposta HTTP
     */
    protected function getReasonPhraseByStatusCode(int $statusCode): string
    {
        switch ($statusCode) {
            case OK:
                return 'OK';
            break;
            case CREATED:
                return 'Created';
            break;
            case ACCEPTED:
                return 'Accepted';
            break;
            case NO_CONTENT:
                return 'No Content';
            break;
            case BAD_REQUEST:
                return 'Bad Request';
            break;
            case UNAUTHORIZED:
                return 'Unauthorized';
            break;
            case FORBIDDEN:
                return 'Forbidden';
            break;
            case NOT_FOUND:
                return 'Not Found';
            break;
            case METHOD_NOT_ALLOWED:
                return 'Method Not Allowed';
            break;
            case NOT_ACCEPTABLE:
                return 'Not Acceptable';
            break;
            case REQUEST_TIMEOUT:
                return 'Request Time-out';
            break;
            case GONE:
                return 'Gone';
            break;
            case SERVER_ERROR:
                return 'Internal Server Error';
            break;
            case NOT_IMPLEMENTED:
                return 'Not Implemented';
            break;
            case BAD_GETEWAY:
                return 'Bad Gateway';
            break;
            case SERVICE_UNAVAILABLE:
                return 'Service Unavailable';
            break;
            case GETEWAY_TIMEOUT:
                return 'Gateway Time-out';
            break;
        }
        return '';
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
    }
}
