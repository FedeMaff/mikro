<?php

/**
 * CriteriaTranspiler.php
 * Mikro\Tools\CriteriaTranspiler
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Tools;

use Mikro\Entity\EntityInterface;
use Mikro\Repository\Criteria\CriteriaInterface;
use Mikro\Repository\Criteria\Criteria;
use Mikro\Repository\Criteria\FiltersInterface;
use Mikro\Repository\Criteria\Filters;
use Mikro\Repository\Criteria\Filter\FilterInterface;
use Mikro\Repository\Criteria\FiltersGroup\FiltersGroupInterface;
use Mikro\Repository\Criteria\PaginationInterface;
use Mikro\Repository\Criteria\Pagination;
use Mikro\Repository\Criteria\SortingInterface;
use Mikro\Repository\Criteria\Sorting;
use Mikro\Factory\FilterFactory;
use Mikro\Factory\FiltersGroupFactory;
use Mikro\Tools\CaseConverter;
use Mikro\Tools\CriteriaFormatter;
use Mikro\Settings;
use ReflectionClass;
use ReflectionProperty;
use ReflectionMethod;
use DateTime;

/**
 * Classe di transpilazione dedicata alla conversione di un array in
 * un istanza Criteria. Questa classe permetterà di ottimizzare la traduzione
 * di un array associativo strutturato in un insieme di filtri, ordinamente,
 * paginazione e proprietà di ritorno incapsulate in un istanza Criteria.
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class CriteriaTranspiler
{
    /**
     * Elenco completo operatori di filtro
     *
     * @var array OPERATORS operatori di filtro
     */
    public const OPERATORS = [
        OPERATOR_EQUAL,
        OPERATOR_NOT_EQUAL,
        OPERATOR_LESS_THAN,
        OPERATOR_LESS_THAN_OR_EQUAL,
        OPERATOR_GREATER_THAN,
        OPERATOR_GREATER_THAN_OR_EQUAL,
        OPERATOR_STARTS_WITH,
        OPERATOR_ENDS_WITH,
        OPERATOR_CONTAINS,
        OPERATOR_NOT_CONTAINS,
        OPERATOR_IS_NULL,
        OPERATOR_IS_NOT_NULL,
        OPERATOR_IN,
        OPERATOR_NOT_IN
    ];
    /**
     * Array parametri di ricerca / filtro / paginazione / ordinamento / fields
     *
     * @var array $array Array associativo multidimensionale
     */
    private array $array = [];

    /**
     * Struttura entità tipizzata in formato array
     *
     * @var array $struct Struttura entità ( Ricorsiva )
     */
    private array $struct = [];

    /**
     * Array di formattatori
     *
     * @var CriteriaFormatter[] $formatters Collezione di formattatori
     */
    private array $formatters = [];

    /**
     * Costruttore
     *
     * @param array $array Array associativo multidimensionale
     * @param EntityInterface $entity Istanza entità
     * @param CriteriaFormatter[] $formatters Collezione di formattatori
     *
     * @return CriteriaInterface
     */
    public function __construct(array $array = [], array $struct = [], array $formatters = [])
    {
        $this->array = $array;
        $this->struct = $struct;
        $this->formatters = $formatters;
    }

    /**
     * Costruzione istanza CriteriaInterface da array
     *
     * @param array $array Array associativo multidimensionale
     * @param EntityInterface $entity Istanza entità
     * @param CriteriaFormatter[] $formatters Collezione di formattatori
     *
     * @return CriteriaInterface
     */
    public static function transpile(
        array $array,
        EntityInterface $entity,
        CriteriaFormatter ...$formatters
    ): CriteriaInterface {

        $cache = Settings::getCache();
        if (!is_null($cache)) {
            $reference = sprintf('parseEntity_%s', get_class($entity));
            $content = $cache->read($reference);
            $struct = is_null($content) ? static::parseEntity($entity) : unserialize($content);
            $content == null && $cache->write($reference, serialize($struct));
        } else {
            $struct = self::parseEntity($entity);
        }
        return (new self($array, $struct, $formatters))->buildCriteria();
    }

    /**
     * Metodo di orchestrazione costruzione istanza Criteria
     *
     * @return CriteriaInterface
     */
    public function buildCriteria(): CriteriaInterface
    {
        $filters = isset($this->array[FILTERS_KEY]) ? $this->array[FILTERS_KEY] : null;
        $filters = is_array($filters) ? $this->parseFilters($filters) : null;
        $pagination = isset($this->array[PAGINATION_KEY]) ? $this->array[PAGINATION_KEY] : null;
        $pagination = is_array($pagination) ? $this->parsePagination($pagination) : null;
        $sortings = isset($this->array[SORTINGS_KEY]) ? $this->array[SORTINGS_KEY] : [];
        $sortings = is_array($sortings) ? $this->parseSortings($sortings) : [];
        $fields = isset($this->array[FIELDS_KEY]) ? $this->array[FIELDS_KEY] : [];
        $fields = is_array($fields) ? $this->parseFields($fields) : [];
        return new Criteria($filters, $pagination, $sortings, $fields);
    }

    /**
     * Costruzione istanza FiltersInterface come prodotto dell'analisi
     * tra array di filtri e struttura entità
     *
     * @param array $array Array associativo multidimensionale di filtri
     * @param ?string $operator Operatore di aggregazione
     *
     * @return ?FiltersInterface
     */
    protected function parseFilters(array $array = [], string $operator = null): ?FiltersInterface
    {

        $filters = [];
        $groups = [];
        $filtersLists = $this->isIndexedArray($array) ? $array : [$array];

        // Nel eseguire i test è emerso che in caso si desideri filtrare con l'operatore
        // "OPERATOR_OR" su medesima chiave il sistema di array associativi non permette
        // un parallelismo in quanto la medesima chiave comporta una sovrascrittura del
        // valore precedente. Pertanto è stata introdotta la funzionalità isIndexedArray
        // che permette di identificare gli array sequenziali/indexed e gestire con un
        // loop aggiuntivo la corretta "traspilazione".

        foreach ($filtersLists as $filtersList) {
            foreach ($filtersList as $field => $value) {
                # Se il valore della chiave non è un array passo oltre
                if (!is_array($value)) {
                    continue;
                }

                # Se la chiave dell'array è uno degli operatori di raggruppamento
                # demando al metodo dedicato il parsing.
                if (in_array($field, [OPERATOR_AND, OPERATOR_OR])) {
                    $groups[] = $this->parseFilters($value, $field);
                    continue;
                }

                # Se la chiave dell'array non è uno degli operatori di raggruppamento
                # demando al metodo dedicato il parsing verificando se la prima chiave
                # dell'array $value è di tipo OPERATOR.
                $filters = array_merge($filters, $this->parseRecursiveFilter($field, $value));
            }
        }

        return is_null($operator)
             ? new Filters($filters, $groups)
             : FiltersGroupFactory::create($operator, $filters, $groups);
    }

    /**
     * Costruzione istanza PaginationInterface dato array di richiesta
     *
     * @param array $array Array associativo multidimensionale di filtri
     *
     * @return ?PaginationInterface
     */
    protected function parsePagination(array $array = []): ?PaginationInterface
    {
        $page = isset($array[PAGINATION_PAGE_KEY]) ? $array[PAGINATION_PAGE_KEY] : null;
        $page = is_numeric($page) ? (int)$page : 1;

        $limit = isset($array[PAGINATION_LIMIT_KEY]) ? $array[PAGINATION_LIMIT_KEY] : null;
        $limit = is_numeric($limit) ? (int)$limit : DEFAULT_PAGINATION;

        return new Pagination($page, $limit);
    }

    /**
     * Costruzione array di SortingInterface dato array di richiesta
     *
     * @param array $array Array associativo multidimensionale di filtri
     *
     * @return SortingInterface[]
     */
    protected function parseSortings(array $array = []): array
    {
        $sortings = [];
        $types = ['array','bool','DateTime','float','int','string'];
        foreach ($array as $field => $value) {
            if (in_array($value, [ORDER_ASC, ORDER_DESC])) {
                $sanitizedField = $this->sanitizeFieldsChain($field);
                if (is_null($sanitizedField)) {
                    continue;
                }
                if (!in_array($this->getTypeByFieldsChain($field), $types)) {
                    continue;
                }
                $sortings[] = new Sorting($sanitizedField, $value);
                continue;
            }

            if (!is_array($value)) {
                continue;
            }
            // Commentando questa funzionalità soltanto i field di tipo "root" potranno
            // essere inclusi nell'elenco di field ordinabili. Tutto il resto verrà omesso.
            $sortings = array_merge($sortings, $this->parseRecursiveSorting($field, $value));
        }

        return $sortings;
    }

    /**
     * Costruzione array di fields dato array di richiesta
     *
     * @param array $array Array associativo multidimensionale di fields
     *
     * @return string[]
     */
    protected function parseFields(array $array = []): array
    {
        $tmpfields = [];
        $types = ['array','bool','DateTime','float','int','string'];
        foreach ($array as $field => $value) {
            $value = empty($value) ? null : $value;
            if (is_null($value)) {
                $sanitizedField = $this->sanitizeFieldsChain($field);
                if (is_null($sanitizedField)) {
                    continue;
                }
                if (!in_array($this->getTypeByFieldsChain($field), $types)) {
                    continue;
                }
                $tmpfields[$sanitizedField] = null;
                continue;
            }

            if (!is_array($value)) {
                continue;
            }

            $tmpfields = array_merge($tmpfields, $this->parseRecursiveField($field, $value));
        }

        $fields = [];
        foreach ($tmpfields as $key => $value) {
            $cursor = &$fields;
            $tails = explode('.', $key);
            foreach ($tails as $tail) {
                if (!array_key_exists($tail, $cursor)) {
                    $cursor[$tail] = [];
                }
                $cursor = &$cursor[$tail];
            }
        }
        return $fields;
    }

    /**
     * Analisi entità ed estrazione proprietà e tipo proprietà in array associativo
     *
     * @param EntityInterface $entity Istanza entità
     *
     * @return array
     */
    private static function parseEntity(EntityInterface $entity): array
    {
        $array = [];
        $reflection = new ReflectionClass($entity);
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            if (strpos($methodName, 'set') !== 0) {
                continue;
            }
            try {
                $type = $method->getParameters()[0]->getType()->getName();
                $propertyName = substr($methodName, 3);
                $propertyNameToLower = strtolower($propertyName);
                $value = null;
                switch ($type) {
                    case 'array':
                    case 'bool':
                    case 'DateTime':
                    case 'float':
                    case 'int':
                    case 'string':
                        $value['type'] = $type;
                        $value['field'] = $propertyName;
                        $value['variadic'] = false;
                        $value['readonly'] = static::propertyIsReadOnly($propertyName, $entity);
                        break;
                    default:
                        $value['type'] = $type;
                        $value['field'] = $propertyName;
                        $value['variadic'] = $method->isVariadic();
                        $value['readonly'] = static::propertyIsReadOnly($propertyName, $entity);
                        $value['fields'] = static::parseEntity(new $type());
                        break;
                }
                $array[$propertyNameToLower] = $value;
            } catch (\Exceptions $e) {
                unset($e);
            }
        }

        return $array;
    }

    /**
     * Parsing array in istanza Filter Ricorsivamente
     *
     * @param string $field Nome proprietà su cui eseguire il filtro
     * @param array $array Array associativo multidimensionale filtro
     * @param ?string $prefix Nome proprietà parent
     *
     * @return FilterInterface[]
     */
    private function parseRecursiveFilter(string $field, array $array = [], ?string $prefix = null): array
    {
        $filters = [];

        $keys = array_keys($array);
        foreach ($keys as $key) {
            $operator = in_array($key, static::OPERATORS) ? $key : null;

            if (!is_null($operator)) {
                $fieldsChain =  (is_null($prefix) ? '' : sprintf('%s.', $prefix)) . $field;
                $type = $this->getTypeByFieldsChain($fieldsChain);
                if ($this->getFlagReadonlyByFieldsChain($fieldsChain)) {
                    continue;
                }

                switch ($type) {
                    case 'bool':
                        $value = $this->valueToBool($array[$operator]);
                        break;
                    case 'Date':
                        $value = $this->valueToDate($array[$operator]);
                        break;
                    case 'DateTime':
                        $value = $this->valueToDateTime($array[$operator]);
                        break;
                    case 'float':
                        $value = in_array($operator, [OPERATOR_IN, OPERATOR_NOT_IN])
                               ? $this->valueToArray($array[$operator])
                               : $this->valueToFloat($array[$operator]);
                        break;
                    case 'int':
                        $value = in_array($operator, [OPERATOR_IN, OPERATOR_NOT_IN])
                               ? $this->valueToArray($array[$operator])
                               : $this->valueToInt($array[$operator]);
                        break;
                    case 'string':
                        $value = in_array($operator, [OPERATOR_IN, OPERATOR_NOT_IN])
                               ? $this->valueToArray($array[$operator])
                               : $this->valueToString($array[$operator]);
                        break;
                    default:
                        $value = null;
                        break;
                }

                if (is_null($value)) {
                    continue;
                }

                switch (true) {
                    case gettype($value) === 'string':
                        $value = $this->applyStringFormatters($fieldsChain, $value);
                        break;
                    case gettype($value) === 'array':
                        foreach ($value as &$tmpValue) {
                            if (gettype($tmpValue) === 'string') {
                                $tmpValue = $this->applyStringFormatters($fieldsChain, $tmpValue);
                            }
                        }
                        break;
                }

                $tmpfield = $this->sanitizeFieldsChain($fieldsChain);
                $filters[] = FilterFactory::create($tmpfield, $operator, $value);
                continue;
            }

            $fieldPrefix = is_null($prefix) ? $field : sprintf('%s.%s', $prefix, $field);
            if (!is_array($array[$key])) {
                continue;
            }
            $filters = array_merge($filters, $this->parseRecursiveFilter($key, $array[$key], $fieldPrefix));
        }

        return array_filter($filters);
    }

    /**
     * Recupero tipo dato da fieldsChain
     *
     * @param string $fieldsChain Percorso field generato dai parametri di richiesta
     *
     * @return ?string
     */
    private function getTypeByFieldsChain(string $fieldsChain): ?string
    {
        $newFieldsChain = '';
        $struct = $this->struct;
        $type = null;
        $fields = explode('.', $fieldsChain);

        foreach ($fields as $field) {
            $field = strtolower($field);
            if (!isset($struct[$field])) {
                return null;
            }
            $type = isset($struct[$field]['type']) ? $struct[$field]['type'] : null;
            $struct = isset($struct[$field]['fields']) ? $struct[$field]['fields'] : [];
        }

        return $type;
    }

    /**
     * Recupero flag readonly da fieldsChain
     *
     * @param string $fieldsChain Percorso field generato dai parametri di richiesta
     *
     * @return bool
     */
    private function getFlagReadonlyByFieldsChain(string $fieldsChain): bool
    {
        $newFieldsChain = '';
        $struct = $this->struct;
        $readonly = null;
        $fields = explode('.', $fieldsChain);

        foreach ($fields as $field) {
            $field = strtolower($field);
            if (!isset($struct[$field])) {
                return true;
            }
            $readonly = isset($struct[$field]['readonly']) ? $struct[$field]['readonly'] : true;
            $struct = isset($struct[$field]['fields']) ? $struct[$field]['fields'] : [];
            if ($readonly) {
                return true;
            }
        }

        return $readonly;
    }

    /**
     * Applicazione formattatori di stringa
     * Questo metodo verifica se tra i formatters d'istanza sono presenti dei formattatori
     * che rispondo alla stringa $fieldsChain se l'esito è affermativo vengono eseguiti
     * i formattatori sulla stringa e restitutita la stringa risultante. In caso contrario
     * viene ritornata la stringa in ingresso.
     *
     * @param string $fieldsChain Percorso field generato dai parametri di richiesta
     * @param string $string Valore oggetto di formattazione
     *
     * @return string
     */
    private function applyStringFormatters(string $fieldsChain, string $string): string
    {
        if (empty($this->formatters)) {
            return $string;
        }

        foreach ($this->formatters as $formatter) {
            if (!in_array($formatter->getFieldsChain(), [$fieldsChain, '*'])) {
                continue;
            }
            $string = $formatter($string);
        }

        return $string;
    }

    /**
     * Recupero flag variadic da fieldsChain
     *
     * @param string $fieldsChain Percorso field generato dai parametri di richiesta
     *
     * @return bool
     */
    private function fieldsChainIsVariadic(string $fieldsChain): bool
    {
        $newFieldsChain = '';
        $struct = $this->struct;
        $variadic = false;
        $fields = explode('.', $fieldsChain);

        foreach ($fields as $field) {
            if (!isset($struct[$field])) {
                return null;
            }

            # Se durante il percorso "chain" di costruzione del field si incontra una variabile
            # di tipo variadic ( Object ...$array ) il field viene omesso dai criteria.
            $flagVariadic = isset($struct[$field]['variadic']) ? $struct[$field]['variadic'] : false;
            $variadic = $flagVariadic == true ? true : $variadic;

            $struct = isset($struct[$field]['fields']) ? $struct[$field]['fields'] : [];
        }
        return $variadic;
    }

    /**
     * Parsing array in istanza Ordinamento ricorsivamente
     *
     * @param string $field Nome proprietà su cui eseguire il filtro
     * @param array $array Array associativo multidimensionale filtro
     * @param ?string $prefix Nome proprietà parent
     *
     * @return SortingInterface[]
     */
    private function parseRecursiveSorting(string $field, array $array = [], ?string $prefix = null): array
    {
        $sortings = [];
        $types = ['array','bool','DateTime','float','int','string'];
        foreach ($array as $key => $value) {
            $order = in_array($value, [ORDER_ASC, ORDER_DESC]) ? $value : null;
            if (!is_array($value) && is_null($order)) {
                continue;
            }
            if (!is_null($order)) {
                $fieldsChain =  (is_null($prefix) ? sprintf('%s.', $field) : sprintf('%s.%s.', $prefix, $field)) . $key;
                $tmpfield = $this->sanitizeFieldsChain($fieldsChain);
                if (is_null($tmpfield)) {
                    continue;
                }
                if ($this->getFlagReadonlyByFieldsChain($fieldsChain)) {
                    continue;
                }
                if (!in_array($this->getTypeByFieldsChain($fieldsChain), $types)) {
                    continue;
                }
                if ($this->fieldsChainIsVariadic($fieldsChain)) {
                    continue;
                }
                $sortings[] = new Sorting($tmpfield, $order);
                continue;
            }

            $fieldPrefix = is_null($prefix) ? $field : sprintf('%s.%s', $prefix, $field);
            $sortings = array_merge($sortings, $this->parseRecursiveSorting($key, $array[$key], $fieldPrefix));
        }

        return array_filter($sortings);
    }

    /**
     * Parsing array in field ricorsivamente
     *
     * @param string $field Nome proprietà su cui eseguire il filtro
     * @param array $array Array associativo multidimensionale filtro
     * @param ?string $prefix Nome proprietà parent
     *
     * @return string[]
     */
    private function parseRecursiveField(string $field, array $array = [], ?string $prefix = null): array
    {
        $fields = [];
        $types = ['array','bool','DateTime','float','int','string'];
        foreach ($array as $key => $value) {
            if (!is_array($value) && !is_null($value) && !(is_string($value) && empty($value))) {
                continue;
            }
            if (is_null($value) || empty($value)) {
                $fieldsChain =  (is_null($prefix) ? sprintf('%s.', $field) : sprintf('%s.%s.', $prefix, $field)) . $key;
                $tmpfield = $this->sanitizeFieldsChain($fieldsChain);
                if (is_null($tmpfield)) {
                    continue;
                }
                if (!in_array($this->getTypeByFieldsChain($fieldsChain), $types)) {
                    continue;
                }
                $fields[$tmpfield] = null;
                continue;
            }
            $fieldPrefix = is_null($prefix) ? $field : sprintf('%s.%s', $prefix, $field);
            $fields = array_merge($fields, $this->parseRecursiveField($key, $array[$key], $fieldPrefix));
        }

        return $fields;
    }

    /**
     * Trasformazione percorso parametri lower-case di richiesta in percorso strutturato
     * da nome proprietà entità.
     *
     * @param string $fieldsChain Percorso field generato dai parametri di richiesta
     *
     * @return ?string
     */
    private function sanitizeFieldsChain(string $fieldsChain): ?string
    {
        $newFieldsChain = '';
        $struct = $this->struct;
        $fields = explode('.', $fieldsChain);
        $types = ['array','bool','DateTime','float','int','string'];

        foreach ($fields as $field) {
            $field = strtolower($field);
            if (!isset($struct[$field])) {
                return null;
            }
            $type = isset($struct[$field]['type']) ? $struct[$field]['type'] : '';
            $fieldName = $struct[$field]['field'];

            try {
                # Nel caso in cui il tipo di field non rientri nell'elenco
                # la funzione prova ad istanziare la classe $type se ci riesce
                # ne recupera il nome e lo utilizza al posto della variabile.
                $fieldName = !in_array($type, $types) ? (new \ReflectionClass($type))->getShortName() : $fieldName;
            } catch (\Exception $e) {
                unset($e);
            }

            $newFieldsChain = empty($newFieldsChain)
                        ? $this->sanitizeFieldCase($fieldName)
                        : sprintf('%s.%s', $newFieldsChain, $this->sanitizeFieldCase($fieldName));
            $struct = isset($struct[$field]['fields'])
                    ? $struct[$field]['fields']
                    : [];
        }

        return $newFieldsChain;
    }

    /**
     * Data una proprietà di classe Entity questa funzione verifica l'esistenza e
     * la presenza di eventuale flag di omissione.
     *
     * Il flag di omissione permette all'utilizzatore di dichiarare una proprietà
     * dell'entità come di sola lettura. Le proprietà soggette a flag di omissione
     * potranno solamente essere soggette alle dichiarazioni di tipo "fields".
     *
     * Il flag di omissione è: @readonly è viene ricercato nel commento PSR12 della
     * proprietà di classe $entity.
     *
     * @param string $propertyName Nome proprietà
     * @param EntityInterface $entity Istanza entità
     *
     * @return bool
     */
    private static function propertyIsReadOnly(string $propertyName, EntityInterface $entity): bool
    {
        $readonly = null;
        $reflection = new ReflectionClass($entity);
        foreach ($reflection->getProperties() as $property) {
            if (strtolower($property->name) != strtolower($propertyName)) {
                continue;
            }
            $comment = $property->getDocComment();
            $comment = !is_string($comment) ? '' : $comment;
            $readonly = strpos($comment, READONLY_PROPERTY) !== false ? true : false;
        }
        return is_null($readonly) ? true : $readonly;
    }

    /**
     * Conversione CASE del field
     *
     * @param string $string Nome proprietà
     *
     * @return string
     */
    private function sanitizeFieldCase(string $string): string
    {
        $case = Settings::getRepositoryFieldCase();
        switch ($case) {
            case CAMEL_CASE:
                $string = CaseConverter::toCamelCase($string);
                break;
            case PASCAL_CASE:
                $string = CaseConverter::toPascalCase($string);
                break;
            case SNAKE_CASE:
                $string = CaseConverter::toSnakeCase($string);
                break;
            case KEBAB_CASE:
                $string = CaseConverter::toKebabCase($string);
                break;
        }
        return $string;
    }

    /**
     * Conversione da valore any a valore buleano
     *
     * @param any $value Valore
     *
     * @return ?bool
     */
    private function valueToBool($value): ?bool
    {
        $bool = null;
        switch (true) {
            case (in_array($value, ['0', 0, false, false, 'false', '', null])):
                $bool = false;
                break;
            case (in_array($value, ['1', 1, true, true, 'true'])):
                $bool = true;
                break;
        }
        return $bool;
    }

    /**
     * Conversione da valore any a valore DateTime ( data )
     *
     * @param any $value Valore
     *
     * @return ?DateTime
     */
    private function valueToDate($value): ?DateTime
    {
        if (!is_string($value)) {
            return null;
        }
        $date = DateTime::createFromFormat(PARSE_DATE_FORMAT, $value);
        return ($date->format(PARSE_DATE_FORMAT) == $value) ? $date : null;
    }

    /**
     * Conversione da valore any a valore DateTime ( data e ora )
     *
     * @param any $value Valore
     *
     * @return ?DateTime
     */
    private function valueToDateTime($value): ?DateTime
    {
        if (!is_string($value)) {
            return null;
        }
        $datetime = DateTime::createFromFormat(PARSE_DATE_TIME_FORMAT, $value);
        return ($datetime->format(PARSE_DATE_TIME_FORMAT) == $value) ? $datetime : null;
    }

    /**
     * Conversione da valore any in a array di stringhe
     *
     * @param any $value Valore
     *
     * @return ?array
     */
    private function valueToArray($value): ?array
    {
        if (!is_array($value)) {
            return null;
        }
        $array = [];
        foreach ($value as $key => $value) {
            if (!in_array(gettype($value), ['double', 'float', 'integer', 'string'])) {
                continue;
            }
            $array[] = (string)$value;
        }
        return empty($array) ? null : $array;
    }

    /**
     * Conversione da valore any a valore numero decimale
     *
     * @param any $value Valore
     *
     * @return ?float
     */
    private function valueToFloat($value): ?float
    {
        $float = null;
        switch (true) {
            case (is_numeric($value)):
                $float = (float)$value;
                break;
            case (is_float($value)):
                $float = (float)$value;
                break;
        }
        return $float;
    }

    /**
     * Conversione da valore any a valore intero
     *
     * @param any $value Valore
     *
     * @return ?int
     */
    private function valueToInt($value): ?int
    {
        $int = null;
        switch (true) {
            case (is_int($value)):
                $int = (int)$value;
                break;
            case ((int)$value == $value):
                $int = (int)$value;
                break;
        }
        return $int;
    }

    /**
     * Conversione da valore any a valore stringa
     *
     * @param any $value Valore
     *
     * @return ?string
     */
    private function valueToString($value): ?string
    {
        $string = null;
        switch (true) {
            case (empty($value) || is_string($value)):
                $string = (string)$value;
                break;
            case (is_numeric($value)):
                $string = (string)$value;
                break;
            case (is_float($value)):
                $string = (string)$value;
                break;
        }
        return $string;
    }

    /**
     * Verifica di tutte le chiavi di un array, nel caso in cui
     * si tratti di un array posizionale/sequenziale questo metodo
     * ritorna true in caso contrario ( array associativo ) ritorna
     * false.
     *
     * @param array $array Array da verificare
     *
     * @return bool
     */
    private function isIndexedArray(array $array): bool
    {
        $isIndexed = true;
        foreach ($array as $key => $value) {
            if (!is_numeric($key) || (int)$key != $key) {
                $isIndexed = false;
            }
        }
        return $isIndexed;
    }
}
