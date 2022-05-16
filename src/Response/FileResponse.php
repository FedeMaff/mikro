<?php

/**
 * FileResponse.php
 * Mikro\Response\FileResponse
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Response;

use Mikro\Response\FileResponseInterface;
use Mikro\Exceptions\FileReadException;

/**
 * Implementazione concreta risposta http File
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class FileResponse implements FileResponseInterface
{
    /**
     * Percorso file
     *
     * @var ?string $filePath Percorso file
     */
    private ?string $filePath = null;

    /**
     * Costruttore
     *
     * @param string $filePath Percorso file
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath)) {
            $message[] = 'Nel tentativo di istanziare la classe FileResponse';
            $message[] = sprintf('la verifica di esistenza del percorso "%s"', $this->filePath);
            $message[] = 'ha dato esito negativo. Il file non esiste';
            $message = implode(' ', $message);
            $this->throwFileReadException($message);
        }
    }

    /**
     * Recupero contenuto response
     *
     * @return string
     */
    public function __toString(): string
    {
        $resource = fopen($this->filePath, 'rb');

        if (gettype($resource) !== 'resource') {
            $message[] = 'La lettura del contenuto binario del file';
            $message[] = sprintf('"%s"', $this->filePath);
            $message[] = 'e\' stata interrotta. Il contenuto non e\' di tipo "resource"';
            $message = implode(' ', $message);
            $this->throwFileReadException($message);
        }

        $resourceType = get_resource_type($resource);
        if ($resourceType !== 'stream') {
            $message[] = 'La lettura del contenuto binario del file';
            $message[] = sprintf('"%s"', $this->filePath);
            $message[] = 'e\' stata interrotta. Il tipo di risorsa';
            $message[] = sprintf('e\' "%s"', is_null($resourceType) ? 'null' : $resourceType);
            $message[] = 'anzi che "stream"';
            $message = implode(' ', $message);
            $this->throwFileReadException($message);
        }

        $string = '';
        while (!feof($resource)) {
            $string .= fread($resource, FILE_CHUNK_SIZE);
        }

        fclose($resource);
        return $string;
    }

    /**
     * Recupero percorso file
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Avvio eccezione errore lettura file
     *
     * @param string $message Messaggio di errore
     *
     * @return void
     */
    private function throwFileReadException(string $message): void
    {
        $exception = new FileReadException($message);
        $exception->setFilePath($this->filePath);
        throw $exception;
    }
}
