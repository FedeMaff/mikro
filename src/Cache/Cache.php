<?php

/**
 * Cache.php
 * Mikro\Cache\Cache
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Cache;

use Mikro\Cache\CacheInterface;
use Mikro\Settings;
use Mikro\Exceptions\NotSetException;
use Mikro\Exceptions\FileWriteException;
use Mikro\Exceptions\FileReadException;

/**
 * Implementazione concreta sitema di cache integrato
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Cache implements CacheInterface
{
    /**
     * Recupero contenuto da cache
     *
     * @param string $reference Identificativo di riferimento
     *
     * @return ?string
     */
    public function read(string $reference): ?string
    {
        $cacheDir = $this->getCacheDir();
        $hash = md5($reference);
        $cacheFileName = sprintf('%s.cache', $hash);
        $cacheFilePath = sprintf('%s/%s', $cacheDir, $cacheFileName);
        if (!file_exists($cacheFilePath)) {
            return null;
        }
        $content = file_get_contents($cacheFilePath);
        if ($content === false) {
            $this->throwFileReadException($cacheFilePath);
        }
        return $content;
    }

    /**
     * Scrittura contenuto in cache
     *
     * @param string $reference Identificativo di riferimento
     * @param string $content Contenuto
     *
     * @return void
     */
    public function write(string $reference, string $content): void
    {
        $cacheDir = $this->getCacheDir();
        $hash = md5($reference);
        $cacheFileName = sprintf('%s.cache', $hash);
        $cacheFilePath = sprintf('%s/%s', $cacheDir, $cacheFileName);
        $handle = fopen($cacheFilePath, 'w');
        if ($handle === false) {
            $this->throwFileWriteException($cacheFilePath);
        }
        fwrite($handle, $content);
        fclose($handle);
        if (!file_exists($cacheFilePath)) {
            $this->throwFileWriteException($cacheFilePath);
        }
    }

    /**
     * Recupero percorso root cache integrata
     *
     * @return string
     */
    protected function getCacheDir(): string
    {
        $cacheDir = Settings::getCacheDir();
        if (!is_dir($cacheDir)) {
            $this->throwNotSetCacheDir();
        }
        return $cacheDir;
    }

    /**
     * Avvio eccezione NotSetException
     *
     * @return void
     */
    private function throwNotSetCacheDir(): void
    {
        $message[] = 'Nel tentativo di leggere e/o scrivere';
        $message[] = 'contenuti in cache si e\' verificato un errore dovuto';
        $message[] = 'alla mancata configurazione del parametro "cacheDir".';
        $message[] = 'Si consiglia di verificare la costante DEFAULT_CACHE_DIR';
        $message[] = 'o l\'assegnazione attraverso l\'istanza statica di configurazione';
        $message[] = 'Settings::setCacheDir()';
        $message = implode(' ', $message);
        throw new NotSetException($message);
    }

    /**
     * Avvio eccezione errore lettura file
     *
     * @param string $filePath Percorso file oggetto di eccezione
     *
     * @return void
     */
    private function throwFileReadException(string $filePath): void
    {
        $message[] = 'Nel tentativo di leggere un contenuto di cache si e\' verificato';
        $message[] = sprintf('un errore di lettura sul file: %s', $filePath);
        $message = implode(' ', $message);
        $exception = new FileReadException($message);
        $exception->setFilePath($filePath);
        throw $exception;
    }

    /**
     * Avvio eccezione errore scrittura file
     *
     * @param string $filePath Percorso file oggetto di eccezione
     *
     * @return void
     */
    private function throwFileWriteException(string $filePath): void
    {
        $message[] = 'Nel tentativo di scrivere un contenuto in cache si e\' verificato';
        $message[] = sprintf('un errore di scrittura sul file: %s', $filePath);
        $message = implode(' ', $message);
        $exception = new FileWriteException($message);
        $exception->setFilePath($filePath);
        throw $exception;
    }
}
