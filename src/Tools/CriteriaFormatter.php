<?php

/**
 * CriteriaFormatter.php
 * Mikro\Tools\CriteriaFormatter
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Tools;

use Mikro\Formatter\StringFormatterInterface;

/**
 * Formattatore di criterio.
 * In determinati casi d'uso i dati "postati" via API vengono modificati ed archiviati
 * se immaginiamo la password di un utente, l'API "raccoglie" il parametro password "12345"
 * ma poi nel database inserisce un valore riclassificato da uno specifico formattatore
 * che trasforma questa stringa di esempio in una stringa alfanumerica complessa:
 *
 * Es. ja8sdjsa8dsa89d9as0d0as9djdas9dasjdjd9sajda
 *
 * In questo caso il sistema di CRITERIA si compromette, ovvero un consumer dell'API
 * potrebbe pensare di recuperare un utente filtrando i risultati dove password è uguale a "12345".
 *
 * Ma il sistema API Mikro risponderebbe con "nessun risultato".
 *
 * Per ovviare a questa dinamica, nasce l'esigenza del componente "Formattatore di criterio" che
 * permette in fase di traspilazione dell'array di criteri di integrare regole specifiche per
 * formattare dati in ingresso.
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class CriteriaFormatter
{
    /**
     * Formattatore
     *
     * @var ?StringFormatterInterface $formatter Istanza formattatore
     */
    private ?StringFormatterInterface $formatter = null;

    /**
     * Catena di nomi proprietà
     * Questa stringa permette di impostare il percorso di una specifica
     * proprietà, la quale sarà il target dell'attività di formatter.
     * Se la stringa è valorizzata con '*' il criterio di formattazione
     * viene applicato a tutte le stringhe in ingresso.
     *
     * @var string $fieldsChain Catena di nomi proprietà
     */
    private string $fieldsChain = '*';

    /**
     * Costruttore
     *
     * @param string $fieldsChain Catena di nomi proprietà
     * @param StringFormatterInterface $formatter Istanza formattatore
     */
    public function __construct(StringFormatterInterface $formatter, string $fieldsChain = '*')
    {
        $this->formatter = $formatter;
        $this->fieldsChain = $fieldsChain;
    }

    /**
     * Recupero catena di nomi proprietà
     *
     * @return string
     */
    public function getFieldsChain(): string
    {
        return $this->fieldsChain;
    }

    /**
     * Esecuzione formatter su stringa in ingresso
     *
     * @param string $string Stringa in ingresso
     *
     * @return string
     */
    public function __invoke(string $string): string
    {
        return ($this->formatter)($string);
    }
}
