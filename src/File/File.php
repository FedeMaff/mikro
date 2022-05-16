<?php

/**
 * File.php
 * Mikro\File\File
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\File;

use Mikro\File\FileInterface;
use Mikro\Exceptions\NotFoundException;

/**
 * Implementazione concreta componente file
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class File implements FileInterface
{
    /**
     * Percorso file
     *
     * @var ?string $path Percorso file
     */
    private ?string $path = null;

    /**
     * Costruttore
     *
     * @var string $path Percorso file
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        if (!file_exists($this->path)) {
            $this->throwNotFoundException();
        }
    }

    /**
     * Recupero percorso file
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Avvio eccezione NotFoundException
     *
     * @return void
     */
    private function throwNotFoundException(): void
    {
        $message[] = 'Inizializzazione oggetto File interrotta';
        $message[] = sprintf('in quanto la verifica del percorso %s', $this->path);
        $message[] = 'ha dato esito negativo. Il file non esiste';
        $message = implode(' ', $message);
        throw new NotFoundException($message);
    }
}
