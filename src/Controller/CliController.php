<?php

/**
 * CliController.php
 * Mikro\Controller\CliController
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Controller;

use Mikro\Controller\ControllerAbstract;
use Mikro\Controller\CliControllerInterface;
use Mikro\Response\ResponseInterface;
use Mikro\Factory\FormatterFactory;
use Mikro\Factory\ResponseFactory;

/**
 * Implementazione astratta controller CLI
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class CliController extends ControllerAbstract implements CliControllerInterface
{
    /**
     * Nome comando di riferimento
     *
     * @var string $commandName Nome comando
     */
    protected static string $commandName = '';

    /**
     * Recupero nome comando di riferimento
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return static::$commandName;
    }

    /**
     * Esecuzione controller e logiche di business implementate
     *
     * @return ?ResponseInterface
     */
    public function run(): ?ResponseInterface
    {
        return null;
    }

    /**
     * Trasformazione valore in response
     *
     * @param any $content Contenuto di risposta
     *
     * @return ResponseInterface
     */
    protected function toResponse($content): ResponseInterface
    {
        $formatter = FormatterFactory::create(TYPE_JSON);
        return ResponseFactory::create($content, $formatter);
    }
}
