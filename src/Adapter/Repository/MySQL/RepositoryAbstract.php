<?php

/**
 * RepositoryAbstract.php
 * Mikro\Adapter\Repository\MySQL\RepositoryAbstract
 *
 * PHP version 7.4
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Adapter\Repository\MySQL;

use Mikro\Repository\RepositoryInterface;
use Mikro\Entity\EntityInterface;
use Mikro\EntityCollection\EntityCollectionInterface;
use Mikro\EntityCollection\EntityCollection;
use Mikro\Repository\Criteria\CriteriaInterface;
use Mikro\Repository\Criteria\FiltersInterface;
use Mikro\Repository\Criteria\Filter\FilterInterface;
use Mikro\Repository\Criteria\Filter\ArrayFilterInterface;
use Mikro\Repository\Criteria\Filter\BoolFilterInterface;
use Mikro\Repository\Criteria\Filter\DateFilterInterface;
use Mikro\Repository\Criteria\Filter\DateTimeFilterInterface;
use Mikro\Repository\Criteria\Filter\FloatFilterInterface;
use Mikro\Repository\Criteria\Filter\IntFilterInterface;
use Mikro\Repository\Criteria\Filter\NullFilterInterface;
use Mikro\Repository\Criteria\Filter\StringFilterInterface;
use Mikro\Repository\Criteria\FiltersGroup\OrGroupInterface;
use Mikro\Repository\Criteria\SortingInterface;
use Mikro\Repository\Criteria\PaginationInterface;
use Mikro\Common\SQL\Connection\ConnectionInterface;
use Mikro\Common\SQL\Exceptions\SQLQueryException;
use Mikro\Common\SQL\Join\JoinInterface;
use Mikro\Common\SQL\Join\JoinInner;
use Mikro\Common\SQL\Join\JoinLeft;
use Mikro\Common\SQL\Join\JoinRight;
use Mikro\Common\SQL\Join\JoinFull;
use PDO;
use DateTime;

/**
 * Implementazione astratta MySQL repository
 *
 * @category  Abstract
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
abstract class RepositoryAbstract implements RepositoryInterface
{
    /**
     * Nome / Chiave di riferimento per la configurazione di connessione
     *
     * Se si sceglie di utilizzare una configurazione di connessione Multiton, è possibile
     * che alcuni repository necessitono di parametri di connessione diversi, di conseguenza
     * sarà necessario poter impostare questa preferenza in fase di implementazione concreta
     * del repository.
     *
     * @var string $confKey Nome / Chiave preferenza connessione
     */
    protected static $confKey = '';

    /**
     * Nome tabella di riferimento
     *
     * @var string $tableName Nome tabella di riferimento
     */
    protected string $tableName = '';

    /**
     * Istanza di connessione MySQL\ConnectionInterface
     *
     * @var ?ConnectionInterface $conn Istanza di connessione
     */
    private ?ConnectionInterface $conn = null;

    /**
     * Istanza entità
     *
     * @var ?EntityInterface $entity Istanza entità di riferimento
     */
    private ?EntityInterface $entity = null;

    /**
     * Collezione di porzioni di query MySQL destinata al find e findAll
     *
     * @var string[] $findQuery Stringhe elementi di query find e findAll
     */
    private array $findQuery = [];

    /**
     * Collezione di parametri da utilizzare nella query MySQL di ricerca
     *
     * @var string[] $findQueryParams Collezione di parametri
     */
    private array $findQueryParams = [];

    /**
     * Collezione di proprietà da includere nell'output dell'entità
     *
     * @var array $fields Array associativo proprietà di output
     */
    private array $fields = [];

    /**
     * Numero di pagina selezionato
     * Questa proprietà dovrà essere valorizzata in fase di assemblaggio della
     * query di ricerca findAll. In quanto sfrutterà la medesima query omettendo i
     * riferimenti di paginazione al fine di garantire una corretta lettura delle
     * informazioni indispensabili alla paginazione del consumer.
     *
     * @var int $page Numero di pagina oggetto di selezione
     */
    private int $page = 1;

    /**
     * Numero di risultati per pagina selezionati
     * Questa proprietà dovrà essere valorizzata in fase di assemblaggio della
     * query di ricerca findAll. In quanto sfrutterà la medesima query omettendo i
     * riferimenti di paginazione al fine di garantire una corretta lettura delle
     * informazioni indispensabili alla paginazione del consumer.
     *
     * @var int $limit Numero di risultati per pagina
     */
    private int $limit = DEFAULT_PAGINATION;

    /**
     * Numero di pagine totali
     * Questa proprietà dovrà essere valorizzata in fase di assemblaggio della
     * query di ricerca findAll. In quanto sfrutterà la medesima query omettendo i
     * riferimenti di paginazione al fine di garantire una corretta lettura delle
     * informazioni indispensabili alla paginazione del consumer.
     *
     * @var int $pages Numero di pagine totali
     */
    private int $pages = 1;

    /**
     * Numero di risultati totali
     * Questa proprietà dovrà essere valorizzata in fase di assemblaggio della
     * query di ricerca findAll. In quanto sfrutterà la medesima query omettendo i
     * riferimenti di paginazione al fine di garantire una corretta lettura delle
     * informazioni indispensabili alla paginazione del consumer.
     *
     * @var int $total Numero di risultati totali
     */
    private int $total = 0;

    /**
     * Recupero statico nome / chiave di riferimento per la configurazione di connessione
     *
     * @return string
     */
    public static function getConfKey(): string
    {
        return static::$confKey;
    }

    /**
     * Costruttore
     *
     * @param ConnectionInterface $conn Istanza connessione MySQL\ConnectionInterface
     * @param EntityInterface $entity Istanza entità oggetto del repository
     * @param string $tableName Nome tabella di riferimento
     *
     * @return void
     */
    public function __construct(ConnectionInterface $conn, EntityInterface $entity, string $tableName)
    {
        $this->conn = $conn;
        $this->entity = $entity;
        $this->tableName = $tableName;
    }

    /**
     * Recupero istanza PDO da connessione locale
     *
     * @return PDO
     */
    protected function getConn(): PDO
    {
        return $this->conn->getConn();
    }

    /**
     * Salvataggio / Aggiornamento entità
     *
     * Questo metodo scriverà la nuova entità sul volume persistente restituendo
     * valorizzati eventuali chiavi "id" dell'entità. Oppure nel caso in cui
     * l'identificativo univoco sia già valorizzato questo metodo aggiornerà con
     * le nuove informazioni l'entità sul volume persistente.
     *
     * @param EntityInterface $entity Istanza entità
     *
     * @return EntityInterface
     */
    abstract public function save(EntityInterface $entity): EntityInterface;

    /**
     * Ricerca singola entità
     *
     * @param ?CriteriaInterface $criteria Istanza criteri di lettura
     *
     * @return ?EntityInterface
     */
    public function find(?CriteriaInterface $criteria = null): ?EntityInterface
    {
        $fields = !is_null($criteria) ? $criteria->getFields() : [];
        $filters = !is_null($criteria) ? $criteria->getFilters() : null;
        $sortings = !is_null($criteria) ? $criteria->getSortings() : [];

        # Assegnazione dati inerenti i fields a livello di istanza
        $this->setFields($fields);

        $this->findQuery[] = $this->getSelectStatement();
        $this->findQuery[] = sprintf('FROM %s', $this->wrapInBackticks($this->tableName));
        $this->assignJoinsToFindQuery();
        $this->assignFiltersToFindQuery($filters);
        $this->findQuery[] = $this->getGroupingStringPolicy();
        $this->assignSortingsToFindQuery(...$sortings);

        $query = implode(' ', $this->findQuery);
        $result = $this->getRow($query, $this->findQueryParams);
        $result = is_null($result) ? null : $this->arrayToEntity($result);

        # Pulizia dati inerenti la findQuery
        $this->cleanFields();
        $this->cleanFindQueryData();

        return $result;
    }

    /**
     * Ricerca elenco etità
     *
     * @param ?CriteriaInterface $criteria Istanza criteri di lettura
     *
     * @return EntityCollectionInterface
     */
    public function findAll(?CriteriaInterface $criteria = null): EntityCollectionInterface
    {
        $fields = !is_null($criteria) ? $criteria->getFields() : [];
        $filters = !is_null($criteria) ? $criteria->getFilters() : null;
        $sortings = !is_null($criteria) ? $criteria->getSortings() : [];
        $pagination = !is_null($criteria) ? $criteria->getPagination() : null;

        # Assegnazione dati inerenti i fields a livello di istanza
        $this->setFields($fields);

        $this->findQuery[] = $this->getSelectStatement();
        $this->findQuery[] = sprintf('FROM %s', $this->wrapInBackticks($this->tableName));
        $this->assignJoinsToFindQuery();
        $this->assignFiltersToFindQuery($filters);
        $this->findQuery[] = $this->getGroupingStringPolicy();
        $this->assignSortingsToFindQuery(...$sortings);
        $this->assignPaginationToFindQuery($pagination);

        $query = implode(' ', $this->findQuery);
        $items = array_map([$this, 'arrayToEntity'], $this->getRows($query, $this->findQueryParams));

        # Pulizia dati inerenti la findQuery
        $this->cleanFields();
        $this->cleanFindQueryData();

        return new EntityCollection($this->page, $this->limit, $this->pages, $this->total, ...$items);
    }

    /**
     * Recupero dichiarazione SELECT query SQL
     * Questo metodo protetto darà possibilità a implementazioni concrete di variare
     * lo statement di selezione delle query "findQuery" di sistema.
     *
     * @return string
     */
    protected function getSelectStatement(): string
    {
        return sprintf('SELECT DISTINCT %s.*', $this->wrapInBackticks($this->tableName));
    }

    /**
     * Assegnazione collezione di proprietà da includere nell'output dell'entità
     *
     * @param array $fields Collezione di proprietà da includere nell'output dell'entità
     *
     * @return void
     */
    protected function setFields(array $fields = []): void
    {
        $this->fields = $fields;
    }

    /**
     * Reset collezione di proprietà da includere nell'output dell'entità
     *
     * @return void
     */
    protected function cleanFields(): void
    {
        $this->fields = [];
    }

    /**
     * Dato array di fields questo metodo assembla la dichiarazione di selezione
     *
     * @param array $fields Elenco di campi oggetto di selezione
     *
     * @return string
     */
    protected function fieldsToSelectString(array $fields = []): string
    {
        $keys = empty($fields) ? [] : array_keys($fields);
        $tableName = $this->tableName;
        $wrappedTableName = $this->wrapInBackticks($this->tableName);
        $keys = array_map(function ($key) use ($tableName, $fields) {
            $wrappedKey = $this->wrapInBackticks($key);
            return empty($fields[$key]) ? sprintf('%s.%s', $wrappedTableName, $wrappedKey) : null;
        }, $keys);
        $keys = array_filter($keys);
        if (!empty($keys)) {
            $fixedFields = $this->getFixedFields();
            foreach ($fixedFields as $fixedField) {
                $wrappedFixedField = $this->wrapInBackticks($this->fixedField);
                $keys[] = sprintf('%s.%s', $wrappedTableName, $wrappedFixedField);
            }
        }
        return empty($keys) ? sprintf('%s.*', $wrappedTableName) : implode(', ', $keys);
    }

    /**
     * Recupero definizione field fissi
     *
     * Lavorando con database relazionali spesso vengono inseriti degli identificativi
     * in una tabella che rappresentano righe di un'altra tabella.
     *
     * Se prendiamo per esempio
     *
     * # Users
     * |-----------|----------------------|
     * | Proprietà | Descrizione          |
     * |-----------|----------------------|
     * | id        | Id utente            |
     * | name      | Nome                 |
     * | surname   | Cognome              |
     * | email     | Indirizzo e-mail     |
     * | role_id   | Identificativo ruolo |
     * |-----------|----------------------|
     *
     * # Roles
     * |-----------|--------------|
     * | Proprietà | Tipo         |
     * |-----------|--------------|
     * | id        | Id ruolo     |
     * | code      | Codice ruolo |
     * | name      | name         |
     * |-----------|--------------|
     *
     * Possiamo vedere che il ruolo è "relazionato" all'occorrenza della tabella Users
     * mediante l'inserimento di un indice della tabella "Roles".
     *
     * Perfetto tuttavia l'entità "User" si presenta così:
     *
     * {
     *     "id": 134,
     *     "name": "Federico",
     *     "surname": "Maffucci",
     *     "email": "federico.maffucci@gmail.com",
     *     "role": {
     *         "id": 2,
     *         "code": "ADM",
     *         "name": "Amministratore"
     *     }
     * }
     *
     * Ciò significa che non è presente il field "role_id" nell'entità User.
     *
     * Questo metodo getFixedFields() deve essere implementato permettendo il return
     * di un array posizionale contenente tutti quei fields che "servono" al "rimontaggio"
     * delle sotto-entità ma che non sono field utilizzabili nel sistema Criteria in quanto
     * non aderenti alle proprietà delle entità.
     *
     * @return array
     *
     */
    protected function getFixedFields(): array
    {
        return [];
    }

    /**
     * Assegnazione direttive di JOIN e/o unione tra tabelle a query di ricerca
     *
     * Questo metodo si allaccia al metodo protetto getJoins() e recupera un array
     * di JoinInterface che verrà utilizzato per "assemblare" la relazione/i di join.
     *
     * Se si prende in considerazione l'esempio del metodo successivo il risultato string
     * di questo metodo dovrebbe essere il seguente:
     *
     * // "INNER JOIN `Roles` ON `Users`.`role_id` = `Roles`.`id`";
     *
     * @return void
     */
    protected function assignJoinsToFindQuery(): void
    {
        $joins = [];
        foreach ($this->getJoins() as $join) {
            $joinType = null;
            switch ($join) {
                case ($join instanceof JoinInner):
                    $joinType = 'INNER';
                    break;
                case ($join instanceof JoinLeft):
                    $joinType = 'LEFT';
                    break;
                case ($join instanceof JoinRight):
                    $joinType = 'RIGHT';
                    break;
                case ($join instanceof JoinFull):
                    $joinType = 'FULL';
                    break;
            }

            if (is_null($joinType)) {
                continue;
            }

            $wrappedJoinToTable = $this->wrapInBackticks($join->getToTable());
            $wrappedJoinToField = $this->wrapInBackticks($join->getToField());
            $wrappedJoinFromTable = $this->wrapInBackticks($join->getFromTable());
            $wrappedJoinFromField = $this->wrapInBackticks($join->getFromField());

            $query[] = sprintf('%s JOIN', $joinType);
            $query[] = sprintf('%s', $wrappedJoinToTable);
            $query[] = 'ON';
            $query[] = sprintf('%s.%s', $wrappedJoinFromTable, $wrappedJoinFromField);
            $query[] = '=';
            $query[] = sprintf('%s.%s', $wrappedJoinToTable, $wrappedJoinToField);
            $joins[] = implode(' ', $query);
            $query = null;
        }

        if (empty($joins)) {
            return;
        }

        $this->findQuery[] = implode(' ', $joins);
    }

    /**
     * Recupero definizione join tra tabelle
     * Metodo riservato alle implementazioni concrete, permette di definire in modo strutturato e semplice
     * le join tra varie tabelle.
     *
     * Es. Si sta lavorando su un entità Utente che ha il segunte aspetto:
     *
     * {
     *     "id": 134,
     *     "name": "Federico",
     *     "surname": "Maffucci",
     *     "email": "federico.maffucci@gmail.com",
     *     "role": {
     *         "id": 2,
     *         "code": "ADM",
     *         "name": "Amministratore"
     *     }
     * }
     *
     *
     * Possiamo facilmente ipotizzare 2 tabelle:
     *
     * # Users
     * |-----------|----------------------|
     * | Proprietà | Descrizione          |
     * |-----------|----------------------|
     * | id        | Id utente            |
     * | name      | Nome                 |
     * | surname   | Cognome              |
     * | email     | Indirizzo e-mail     |
     * | role_id   | Identificativo ruolo |
     * |-----------|----------------------|
     *
     *
     * # Roles
     * |-----------|--------------|
     * | Proprietà | Tipo         |
     * |-----------|--------------|
     * | id        | Id ruolo     |
     * | code      | Codice ruolo |
     * | name      | name         |
     * |-----------|--------------|
     *
     *
     * Questo metodo potrebbe quindi essere così implementato:
     *
     * protected function getJoins(): ?string
     * {
     *      $joins[] = new JoinInner($this->tableName, 'role_id', 'Roles', 'id');
     *      return $joins;
     * }
     *
     * @return JoinInterface[]
     */
    protected function getJoins(): array
    {
        return [];
    }

    /**
     * Assegnazione filtri a query di ricerca
     *
     * @param ?FiltersInterface $filters Istanza filtri
     *
     * @return void
     */
    protected function assignFiltersToFindQuery(?FiltersInterface $filters = null): void
    {
        if (is_null($filters)) {
            return;
        }

        $stringFilters = $this->filtersToStringConditions($filters);

        if (empty($stringFilters)) {
            return;
        }

        $this->findQuery[] = sprintf('WHERE %s', $stringFilters);
    }

    /**
     * Generazione stringa politica di raggruppamento per univocità subset query di ricerca
     *
     * Una query MySQL non può organizzare e quindi ordinare risultati riferendosi ad una colonna
     * derivante da una join quando si usa l'operatore DISTINCT. Per questo motivo si rende
     * imprescindibile l'utilizzo dei GROUP BY. In questo modo la query saprà come rendere univoci
     * i risultati, semplicemente forzando un raggruppamento per chiavi.
     *
     * Dato che le chiavi di riferimento della tabella oggetto d'istanza verranno definite nella
     * prossima implementazione astratta, verrà implementato li questo metodo.
     *
     * @return string
     */
    abstract protected function getGroupingStringPolicy(): string;

    /**
     * Assegnazione ordinamenti a query di ricerca
     *
     * @param SortingInterface[] $sortings Collezione di istanze di ordinamento
     *
     * @return void
     */
    protected function assignSortingsToFindQuery(SortingInterface ...$sortings): void
    {
        if (empty($sortings)) {
            return;
        }

        $this->findQuery[] = 'ORDER BY';
        foreach ($sortings as $key => $sorting) {
            $field = $this->localizer($sorting->getField());
            $order = $sorting->getOrder();
            $order = is_null($order) ? DEFAULT_ORDER : $order;
            $operator = $order == ORDER_ASC ? 'ASC' : 'DESC';
            $this->findQuery[] = sprintf($key > 0 ? ',%s %s' : '%s %s', $this->wrapInBackticks($field), $operator);
        }
    }

    /**
     * Assegnazione paginazione a query di ricerca
     *
     * @param ?PaginationInterface $pagination Istanza paginazione
     *
     * @return void
     */
    protected function assignPaginationToFindQuery(?PaginationInterface $pagination = null): void
    {
        $page = is_null($pagination) ? $this->page : $pagination->getPage();
        $page = in_array($page, [0, 1]) ? 0 : $page - 1;
        $limit = is_null($pagination) ? $this->limit : $pagination->getLimit();
        $this->runFindQueryWithoutPaginationAndUpdatePaginationData($page + 1, $limit);
        $from = ($this->page - 1) * $limit;
        $this->findQuery[] = sprintf('LIMIT %s, %s', $from, $limit);
    }

    /**
     * Avvio query priva di paginazione unicamente finalizzato al recupero dei dati
     * di paginazione.
     *
     * @param int $page Pagina richiesta
     * @param int $litmi Numero di risultati richiesti
     *
     * @return void
     */
    protected function runFindQueryWithoutPaginationAndUpdatePaginationData(int $page, int $limit): void
    {
        // Pulizia dati di paginazione
        $this->cleanPaginationData();

        $query[] = 'SELECT';
        $query[] = 'COUNT(*) AS `total`';
        $query[] = 'FROM';
        $query[] = sprintf('(%s) AS tmp', implode(' ', $this->findQuery));
        $query = implode(' ', $query);
        $total = $this->getRow($query, $this->findQueryParams)['total'];

        $pages = ceil((int)$total / $limit);

        $this->page = $pages >= $page ? $page : (($pages == 0) ? 1 : $pages);
        $this->limit = $limit;
        $this->pages = $pages;
        $this->total = $total;
    }

    /**
     * Esecuzione query:
     * inserimento, aggiornamento o eliminazione.
     *
     * Questo metodo ritorna un valore intero
     *
     * - Attività di inserimento ( insert ): identificativo Riga Index
     * - Attività di aggiornamento ( update ): 0
     * - Attività di eliminazione ( delete ): 0
     *
     * @param string $query Query SQL
     * @param array  $queryParams Collezione di parametri
     *
     * @return int
     */
    protected function execute(string $query = '', array $queryParams = []): int
    {
        $conn = $this->getConn();
        $stmt = $conn->prepare($query);
        try {
            $stmt->execute($queryParams);
            return $conn->lastInsertId();
        } catch (\Exception $e) {
            $exception = new SQLQueryException($e->getMessage());
            $exception->setQuery($query);
            $exception->setQueryParams($queryParams);
            throw $exception;
        }
    }

    /**
     * Esecuzione query recupero singola riga in array
     *
     * @param string $query Query SQL
     * @param array  $queryParams Collezione di parametri
     *
     * @return ?array
     */
    protected function getRow(string $query, array $queryParams = []): ?array
    {
        $conn = $this->getConn();
        $stmt = $conn->prepare($query);
        $result = false;
        try {
            $stmt->execute($queryParams);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $exception = new SQLQueryException($e->getMessage());
            $exception->setQuery($query);
            $exception->setQueryParams($queryParams);
            throw $exception;
        }
        return ($result == false || is_null($result) || empty($result)) ? null : $result;
    }

    /**
     * Esecuzione query recupero righe multiple in array
     *
     * @param string $query Query SQL
     * @param array  $queryParams Collezione di parametri
     *
     * @return array
     */
    protected function getRows(string $query, array $queryParams = []): array
    {
        $conn = $this->getConn();
        $stmt = $conn->prepare($query);
        $results = [];
        try {
            $stmt->execute($queryParams);
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $exception = new SQLQueryException($e->getMessage());
            $exception->setQuery($query);
            $exception->setQueryParams($queryParams);
            throw $exception;
        }
        return $results;
    }

    /**
     * Costruzione entità dato array di dati
     *
     * @param array $array Fetch riga database
     *
     * @return EntityInterface
     */
    abstract protected function arrayToEntity(array $array = []): EntityInterface;

    /**
     * Recupero elenco proprietà
     * Questo metodo permette di recuperare un array associativo contenente tutte le
     * proprietà che il consumatore ha richiesto di includere nell'entità di risposta.
     * Se viene passata una chiave $field questo metodo cerca la chiave nell'array associativo
     * $this->fields e ritorna il valore di quella specifica posizione che può essere:
     *
     * - un array associativo di "sotto-chiavi"
     * - null quando non vengono specificate "sotto-chiavi"
     * - null quando la chiave $field non è presente nell'array $this->fields
     *
     * @param ?string $field Nome proprietà
     *
     * @return ?array
     */
    protected function getFields(?string $field = null): ?array
    {
        if (is_null($field)) {
            return $this->fields;
        }
        return array_key_exists($field, $this->fields) ? $this->fields[$field] : null;
    }

    /**
     * Verifica presenza di una specifica proprietà nell'elenco proprietà da
     * rendere disponibili nell'entità di ritorno.
     *
     * @param string $field Nome proprietà
     *
     * @return bool
     */
    protected function fieldExists(string $field): bool
    {
        return array_key_exists($field, $this->fields);
    }

    /**
     * Questo metodo permette all'implementazione concreta di capire se un determinato
     * field è destinato alla "stampa" oppure no.
     *
     * La verifica è così sviluppata:
     *
     * Se il field è presente nell'array d'istanza $this->fields viene stampato. Ma anche
     * se nell'array di istanza $this->fields non sono presenti valori viene stampato in
     * quanto si assume che se non vengono impotati filtri si desideri recuperare l'intero
     * dato strutturato privo di selezione di fields.
     *
     * @param string $field Nome proprietà
     *
     * @return bool
     */
    protected function isPrintableField(string $field): bool
    {
        return array_key_exists($field, $this->fields) || empty($this->fields);
    }

    /**
     * Reset a stato iniziale dei parametri utili alla query di ricerca
     *
     * @return void
     */
    private function cleanFindQueryData(): void
    {
        $this->findQuery = [];
        $this->findQueryParams = [];
    }

    /**
     * Reset a stato iniziale dei parametri di ritorno legati alla paginazione.
     *
     * @return void
     */
    private function cleanPaginationData(): void
    {
        $this->page = 1;
        $this->limit = DEFAULT_PAGINATION;
        $this->pages = 1;
        $this->total = 0;
    }

    /**
     * Conversione istanza FiltersInterface in stringa di condizioni MySQL
     *
     * @param FiltersInterface $filters Istanza filtri / gruppo filtri
     *
     * @return string
     */
    private function filtersToStringConditions(FiltersInterface $filters): string
    {
        $conditions = [];
        foreach ($filters->getFilters() as $filter) {
            $conditions[] = $this->filterToString($filter);
        }
        foreach ($filters->getFiltersGroups() as $group) {
            $conditions[] = sprintf('(%s)', $this->filtersToStringConditions($group));
        }
        $glue = $filters instanceof OrGroupInterface ? ' OR ' : ' AND ';
        return implode($glue, $conditions);
    }

    /**
     * Conversione istanza filtro in condizione SQL
     *
     * @param FilterInterface $filter Istanza filtro
     *
     * @return string
     */
    private function filterToString(FilterInterface $filter): string
    {
        $field = $this->localizer($filter->getField());
        $operator = $filter->getOperator();
        $value = method_exists($filter, 'getValue') ? $filter->getValue() : null;

        switch (true) {
            case ($filter instanceof ArrayFilterInterface):
                return $this->arrayFilterToString($field, $operator, ...$value);
            break;
            case ($filter instanceof BoolFilterInterface):
                return $this->boolFilterToString($field, $operator, $value);
            break;
            case ($filter instanceof DateFilterInterface):
                return $this->dateFilterToString($field, $operator, $value);
            break;
            case ($filter instanceof DateTimeFilterInterface):
                return $this->dateTimeFilterToString($field, $operator, $value);
            break;
            case ($filter instanceof FloatFilterInterface):
                return $this->floatFilterToString($field, $operator, $value);
            break;
            case ($filter instanceof IntFilterInterface):
                return $this->intFilterToString($field, $operator, $value);
            break;
            case ($filter instanceof NullFilterInterface):
                return $this->nullFilterToString($field, $operator);
            break;
            case ($filter instanceof StringFilterInterface):
                return $this->stringFilterToString($field, $operator, $value);
            break;
        }
    }

    /**
     * Conversione istanza filtro array in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     * @param string[] $value Elenco di stinghe
     *
     * @return string
     */
    private function arrayFilterToString(string $field, string $operator, string ...$value): string
    {
        switch ($operator) {
            case OPERATOR_IN:
                return sprintf('%s IN (%s)', $this->wrapInBackticks($field), $this->stringsToString(...$value));
            break;
            case OPERATOR_NOT_IN:
                return sprintf('%s NOT IN (%s)', $this->wrapInBackticks($field), $this->stringsToString(...$value));
            break;
        }
    }

    /**
     * Conversione istanza filtro buleano in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     * @param bool $value Valore buleano
     *
     * @return string
     */
    private function boolFilterToString(string $field, string $operator, bool $value): string
    {
        switch ($operator) {
            case OPERATOR_EQUAL:
                return sprintf('%s = %s', $this->wrapInBackticks($field), $value === true ? 1 : 0);
            break;
            case OPERATOR_NOT_EQUAL:
                return sprintf('%s <> %s', $this->wrapInBackticks($field), $value === true ? 1 : 0);
            break;
        }
    }

    /**
     * Conversione istanza filtro data in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     * @param DateTime $value Data
     *
     * @return string
     */
    private function dateFilterToString(string $field, string $operator, DateTime $value): string
    {
        $hashedField = $this->fieldToHash($field);

        switch ($operator) {
            case OPERATOR_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_FORMAT);
                return sprintf('%s = :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_NOT_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_FORMAT);
                return sprintf('%s <> :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_FORMAT);
                return sprintf('%s < :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_FORMAT);
                return sprintf('%s <= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_FORMAT);
                return sprintf('%s > :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_FORMAT);
                return sprintf('%s >= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
        }
    }

    /**
     * Conversione istanza filtro data e ora in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     * @param DateTime $value Data e ora
     *
     * @return string
     */
    private function dateTimeFilterToString(string $field, string $operator, DateTime $value): string
    {
        $hashedField = $this->fieldToHash($field);

        switch ($operator) {
            case OPERATOR_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_TIME_FORMAT);
                return sprintf('%s = :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_NOT_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_TIME_FORMAT);
                return sprintf('%s <> :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_TIME_FORMAT);
                return sprintf('%s < :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_TIME_FORMAT);
                return sprintf('%s <= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_TIME_FORMAT);
                return sprintf('%s > :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value->format(PARSE_DATE_TIME_FORMAT);
                return sprintf('%s >= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
        }
    }

    /**
     * Conversione istanza filtro numero con decimali in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     * @param float $value Valore numerico con numeri decimali
     *
     * @return string
     */
    private function floatFilterToString(string $field, string $operator, float $value): string
    {
        $hashedField = $this->fieldToHash($field);

        switch ($operator) {
            case OPERATOR_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s = :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_NOT_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s <> :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s < :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s <= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s > :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s >= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
        }
    }

    /**
     * Conversione istanza filtro numero intero in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     * @param float $value Valore numerico intero
     *
     * @return string
     */
    private function intFilterToString(string $field, string $operator, int $value): string
    {
        $hashedField = $this->fieldToHash($field);

        switch ($operator) {
            case OPERATOR_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s = :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_NOT_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s <> :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s < :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_LESS_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s <= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s > :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_GREATER_THAN_OR_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s >= :%s', $this->wrapInBackticks($field), $hashedField);
            break;
        }
    }

    /**
     * Conversione istanza filtro null in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     *
     * @return string
     */
    private function nullFilterToString(string $field, string $operator): string
    {
        switch ($operator) {
            case OPERATOR_IS_NULL:
                return sprintf('%s IS NULL', $this->wrapInBackticks($field));
            break;
            case OPERATOR_IS_NOT_NULL:
                return sprintf('%s IS NOT NULL', $this->wrapInBackticks($field));
            break;
        }
    }

    /**
     * Conversione istanza filtro stringa in condizione SQL
     *
     * @param string $field Nome colonna
     * @param string $operator Tipo operazione
     * @param string $value Valore stringa
     *
     * @return string
     */
    private function stringFilterToString(string $field, string $operator, string $value): string
    {
        $hashedField = $this->fieldToHash($field);

        switch ($operator) {
            case OPERATOR_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s = :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_NOT_EQUAL:
                $this->findQueryParams[$hashedField] = $value;
                return sprintf('%s <> :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_STARTS_WITH:
                $this->findQueryParams[$hashedField] = sprintf('%s%s', $value, '%');
                return sprintf('%s LIKE :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_ENDS_WITH:
                $this->findQueryParams[$hashedField] = sprintf('%s%s', '%', $value);
                return sprintf('%s LIKE :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_CONTAINS:
                $this->findQueryParams[$hashedField] = sprintf('%s%s%s', '%', $value, '%');
                return sprintf('%s LIKE :%s', $this->wrapInBackticks($field), $hashedField);
            break;
            case OPERATOR_NOT_CONTAINS:
                $this->findQueryParams[$hashedField] = sprintf('%s%s%s', '%', $value, '%');
                return sprintf('%s NOT LIKE :%s', $this->wrapInBackticks($field), $hashedField);
            break;
        }
    }

    /**
     * Questo metodo permette di localizzare i field / proprietà derivanti da:
     * filtri e ordinamenti valutando se il field in questione è una proprietà
     * di una sub-tabella oppure è una proprietà locale della tabella in oggetto.
     * Nel caso si riscontri che la proprietà è da inputarsi al nome di una colonna
     * della tabella in oggetto viene aggiunto il prefisso $this->tableName al field.
     * Nel caso in cui, invece, nella stringa venga specificato un path diviso da punti
     * questo metodo recupera gli ultimi 2 elementi dell'array assumendo il penultimo
     * termine quale "nome" di tabella.
     *
     * In ambito NoSQL è possibile filtrare in modo matriaciale, in ambito SQL l'unione
     * di più tabelle porta ad un "appiattimento" delle interconnessioni, "mascherando"
     * sotto il cappello di un nome tabella l'intero set di colonne, questo è il motivo
     * per cui vengono estratti gli ultimi 2 elementi di un path.
     *
     * Es.
     * # Entità
     * {
     *   "name": "Federico",
     *   "surname": "Maffucci",
     *   "tags": [
     *      {
     *         "id": 23,
     *         "name": "computer",
     *         "color": {
     *            "id": 32,
     *            "name": "rosso",
     *            "hex: "#ff0000"
     *         }
     *      }
     *   ]
     * }
     *
     * Se volessi recuperare tutti gli utenti che hanno un tag di colore rosso
     * dovrei filtrare -> tags.color.name = 'rosso'
     *
     * # localizer()
     * Il metodo in oggetto "localizer" mi permetterebbe quindi di trasformare
     * il field "tags.color.name" in "color.name".
     *
     * # Questa è la query corretta:
     * SELECT DISTINCT user.* FROM user
     *   INNER JOIN userTag ON userTag.userId = user.id
     *   INNER JOIN tag ON tag.id = userTag.tagId
     *   INNER JOIN tagColor ON tagColor.tagId = tag.id
     *   INNER JOIN color ON color.id = tagColor.colorId
     * WHERE
     *   color.name = 'rosso'
     *
     *
     * @param string $string Nome field
     *
     * @return string
     */
    private function localizer(string $string): string
    {
        $dotsExists = strpos($string, '.');

        // Se esiste almeno un "." ritorno proprietà field di input
        if ($dotsExists !== false) {
            $pieces = explode('.', $string);
            $pieces = array_slice($pieces, -2, 2, true);
            return implode('.', $pieces);
        }

        return sprintf('%s.%s', $this->tableName, $string);
    }

    /**
     * Avvolge tra Backtricks quote una stringa semplice o concatenata da punti "."
     *
     * @param string $string Field ( nome colonna, tabella o path )
     *
     * @return string
     */
    private function wrapInBackticks(string $string): string
    {
        $output = '';
        $pieces = explode('.', $string);
        foreach ($pieces as $piece) {
            $output = empty($output) ? sprintf('`%s`', $piece) : sprintf('%s.`%s`', $output, $piece);
        }
        return $output;
    }

    /**
     * Trasforma in stringa compatibile con array MySQL una array di stringhe
     *
     * @param string[] $strings Collezione di stringhe
     *
     * @return string
     */
    private function stringsToString(string ...$strings): string
    {
        $output = '';
        foreach ($strings as $string) {
            $output = empty($output)
                    ? sprintf("'%s'", addslashes($string))
                    : sprintf("%s, '%s'", $output, addslashes($string));
        }
        return $output;
    }

    /**
     * Hash stringa field in stringa priva di caratteri speciali univoca.
     * Questo metodo verificia all'interno dei parametri destinati alla query di ricerca
     * eventuali hash simili e genera una chiave variata in caso di omonimie.
     *
     * Ipotizziamo di avere 3 filtri ( Condizioni in OR ) sulla tabella "Users"
     *
     * [FILTERS_KEY][Name][OPERATOR_EQUAL] = 'Federico'
     * [FILTERS_KEY][Name][OPERATOR_EQUAL] = 'Roberto'
     * [FILTERS_KEY][Name][OPERATOR_EQUAL] = 'Gabriele'
     *
     * A questo metodo verrà richiesto di hashare la proprietà field "Name":
     *
     * 1) [FILTERS_KEY][Name][OPERATOR_EQUAL] = 'Federico'
     *    --------------------------------------------------------
     *    Diventerà parte di query: `Name` = :field_name_001
     *    --------------------------------------------------------
     *    Verrà aggiunta anche una chiave all'array "findQueryParmas"
     *    --------------------------------------------------------
     *    findQueryParmas["field_name_001"] = 'Federico'
     *
     *
     * 2) [FILTERS_KEY][Name][OPERATOR_EQUAL] = 'Roberto'
     *    --------------------------------------------------------
     *    Diventerà parte di query: `Name` = :field_name_002
     *    --------------------------------------------------------
     *    Verrà aggiunta anche una chiave all'array "findQueryParmas"
     *    --------------------------------------------------------
     *    findQueryParmas["field_name_002"] = 'Roberto'
     *
     *
     * 2) [FILTERS_KEY][Name][OPERATOR_EQUAL] = 'Gabriele'
     *    --------------------------------------------------------
     *    Diventerà parte di query: `Name` = :field_name_003
     *    --------------------------------------------------------
     *    Verrà aggiunta anche una chiave all'array "findQueryParmas"
     *    --------------------------------------------------------
     *    findQueryParmas["field_name_003"] = 'Gabriele'
     *
     * @param string $field Field ( nome colonna, tabella o path )
     *
     * @return string
     */
    private function fieldToHash(string $field): string
    {
        $field = preg_replace("/[^a-zA-Z0-9]+/", "", $field);
        $hashedField = sprintf('field_%s', $field);
        $index = 1;
        $exists = true;
        while ($exists) {
            $key = sprintf('%s_%s', $hashedField, str_pad($index, 3, "0", STR_PAD_LEFT));
            if (!array_key_exists($key, $this->findQueryParams)) {
                $hashedField = $key;
                $exists = false;
            }
            $index++;
        }
        return $hashedField;
    }
}
