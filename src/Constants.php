<?php

/**
 * Constants.php
 * Mikro\Constants
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

/**
 * Nome servizio di default
 * Il nome del servizio è configurabile creando un file dal modello .mikrorc-example
 * e utilizzando la funzionalità statica Settings::parseFile();
 * Si sceglie di non rendere modificabile da costante/defined il nome del servizio per
 * migliorare la solidità della libreria in quanto il nome servizio deve essere validato.
 *
 * @var string DEFAULT_SERVICE_NAME Nome immodificabile del servizio
 */
define("DEFAULT_SERVICE_NAME", 'Mikro');

/**
 * Percorso file YAML di sistema
 *
 * @var string YAML_DIR_PATH Percorso cartella metadati yaml di sistema
 */
defined('YAML_DIR_PATH') or define("YAML_DIR_PATH", dirname(__DIR__) . '/yaml');

/**
 * Percorso name space implementazione concreta CACHE di sistema
 *
 * @var string SYSTEM_CACHE Name Space implementazione concreta classe cache
 */
defined('SYSTEM_CACHE') or define("SYSTEM_CACHE", 'Mikro\Cache\Cache');

/**
 * Percorso cartella di root file di cache integrata
 *
 * @var string DEFAULT_CACHE_DIR Percorso cartella file di cache integrata
 */
defined('DEFAULT_CACHE_DIR') or define("DEFAULT_CACHE_DIR", dirname(__DIR__) . '/cache');

/**
 * Dimensione chunk di lettura risorse binarie di tipo stream
 *
 * @var string FILE_CHUNK_SIZE Percorso cartella file di cache integrata
 */
defined('FILE_CHUNK_SIZE') or define("FILE_CHUNK_SIZE", 1024 * 1024);

/**
 * Tipo XML
 *
 * @var string TYPE_XML Tipo xml
 */
defined('TYPE_XML') or define("TYPE_XML", "xml");

/**
 * Tipo JSON
 *
 * @var string TYPE_JSON Tipo json
 */
defined('TYPE_JSON') or define("TYPE_JSON", "json");

/**
 * Response code header Esito Positivo
 *
 * @var int OK Esito positivo
 */
defined('OK') or define("OK", 200);

/**
 * Response code header Esito Positivo con creazione/inserimento
 *
 * @var int CREATED creazione/inserimento
 */
defined('CREATED') or define("CREATED", 201);

/**
 * Response code header richiesta accettata
 *
 * @var int ACCEPTED richiesta client accettata
 */
defined('ACCEPTED') or define("ACCEPTED", 202);

/**
 * Response code header risposta senza contenuto
 *
 * @var int NO_CONTENT risposta senza contenuto
 */
defined('NO_CONTENT') or define("NO_CONTENT", 204);

/**
 * Response code header richiesta malformattata
 *
 * @var int BAD_REQUEST richiesta malformattata
 */
defined('BAD_REQUEST') or define("BAD_REQUEST", 400);

/**
 * Response code header richiesta non autorizzata
 *
 * @var int UNAUTHORIZED richiesta non autorizzata
 */
defined('UNAUTHORIZED') or define("UNAUTHORIZED", 401);

/**
 * Response code header Risorsa non accessibile
 *
 * @var int FORBIDDEN Risorsa non accessibile
 */
defined('FORBIDDEN') or define("FORBIDDEN", 403);

/**
 * Response code header Risorsa non trovata
 *
 * @var int NOT_FOUND Risorsa non trovata
 */
defined('NOT_FOUND') or define("NOT_FOUND", 404);

/**
 * Response code header metodo non implemntato
 *
 * @var int METHOD_NOT_ALLOWED metodo non implemntato
 */
defined('METHOD_NOT_ALLOWED') or define("METHOD_NOT_ALLOWED", 405);

/**
 * Response code header richiesta non accettabile
 *
 * @var int NOT_ACCEPTABLE richiesta non accettabile
 */
defined('NOT_ACCEPTABLE') or define("NOT_ACCEPTABLE", 406);

/**
 * Response code header limite di tempo di elaborazione supearato
 *
 * @var int REQUEST_TIMEOUT limite di tempo di elaborazione supearato
 */
defined('REQUEST_TIMEOUT') or define("REQUEST_TIMEOUT", 408);

/**
 * Response code header risora mai più disponibile
 *
 * @var int GONE risora mai più disponibile
 */
defined('GONE') or define("GONE", 410);

/**
 * Response code header errore interno
 *
 * @var int SERVER_ERROR errore interno
 */
defined('SERVER_ERROR') or define("SERVER_ERROR", 500);

/**
 * Response code header richiesta non implementata
 *
 * @var int NOT_IMPLEMENTED richiesta non implementata
 */
defined('NOT_IMPLEMENTED') or define("NOT_IMPLEMENTED", 501);

/**
 * Response code header impossibile recuperare la risorsa
 *
 * @var int BAD_GETEWAY impossibile recuperare la risorsa
 */
defined('BAD_GETEWAY') or define("BAD_GETEWAY", 502);

/**
 * Response code header servizio non disponibile
 *
 * @var int SERVICE_UNAVAILABLE servizio non disponibile
 */
defined('SERVICE_UNAVAILABLE') or define("SERVICE_UNAVAILABLE", 503);

/**
 * Response code header timeout su server esterno
 *
 * @var int GETEWAY_TIMEOUT timeout su server esterno
 */
defined('GETEWAY_TIMEOUT') or define("GETEWAY_TIMEOUT", 504);

/**
 * Etichetta tipo di ordinamento ascendente
 *
 * @var string ORDER_ASC Etichetta tipo di ordinamento ascendente
 */
defined('ORDER_ASC') or define("ORDER_ASC", 'asc');

/**
 * Etichetta tipo di ordinamento discendente
 *
 * @var string ORDER_DESC Etichetta tipo di ordinamento discendente
 */
defined('ORDER_DESC') or define("ORDER_DESC", 'desc');

/**
 * Paginazione di default quando non impostata
 *
 * @var string DEFAULT_PAGINATION Paginazione di default quando non impostata
 */
defined('DEFAULT_PAGINATION') or define("DEFAULT_PAGINATION", 10);

/**
 * Tipo di ordinamento di default quando non impostata
 *
 * @var string DEFAULT_ORDER Tipo di ordinamento di default quando non impostata
 */
defined('DEFAULT_ORDER') or define("DEFAULT_ORDER", ORDER_ASC);

/**
 * Nome proprietà di riferimento per le parametrizzazioni di filtro
 *
 * @var string FILTERS_KEY Nome proprietà di riferimento per le parametrizzazioni di filtro
 */
defined('FILTERS_KEY') or define("FILTERS_KEY", 'filters');

/**
 * Nome proprietà di riferimento per le parametrizzazioni di paginazione
 *
 * @var string PAGINATION_KEY Nome proprietà di riferimento per le parametrizzazioni di paginazione
 */
defined('PAGINATION_KEY') or define("PAGINATION_KEY", 'pagination');

/**
 * Nome proprietà di riferimento per le parametrizzazioni di ordinamento
 *
 * @var string SORTINGS_KEY Nome proprietà di riferimento per le parametrizzazioni di ordinamento
 */
defined('SORTINGS_KEY') or define("SORTINGS_KEY", 'sortings');

/**
 * Nome proprietà di riferimento per le parametrizzazioni delle proprietà di ritorno
 *
 * @var string FIELDS_KEY Nome proprietà di riferimento per le parametrizzazioni delle proprietà di ritorno
 */
defined('FIELDS_KEY') or define("FIELDS_KEY", 'fields');

/**
 * Nome proprietà di riferimento per le parametrizzazioni del nome della proprietà di riferimento
 * per la pagina richiesta.
 *
 * @var string PAGINATION_PAGE_KEY Nome proprietà di riferimento per le parametrizzazioni delle pagina richiesta
 */
defined('PAGINATION_PAGE_KEY') or define("PAGINATION_PAGE_KEY", 'page');

/**
 * Nome proprietà di riferimento per le parametrizzazioni del nome della proprietà di riferimento
 * per il numero di risultati per pagina.
 *
 * @var string PAGINATION_LIMIT_KEY Nome proprietà di riferimento per le parametrizzazioni dei records per pagina
 */
defined('PAGINATION_LIMIT_KEY') or define("PAGINATION_LIMIT_KEY", 'limit');

/**
 * Nome proprietà di riferimento per le parametrizzazioni del formato "Date"
 *
 * @var string PARSE_DATE_FORMAT Nome proprietà di riferimento per le parametrizzazioni del formato "Date"
 */
defined('PARSE_DATE_FORMAT') or define("PARSE_DATE_FORMAT", 'Y-m-d');

/**
 * Nome proprietà di riferimento per le parametrizzazioni del formato "DateTime"
 *
 * @var string PARSE_DATE_TIME_FORMAT Nome proprietà di riferimento per le parametrizzazioni del formato "DateTime"
 */
defined('PARSE_DATE_TIME_FORMAT') or define("PARSE_DATE_TIME_FORMAT", 'Y-m-d H:i:s');

/**
 * Operatore aggregatore di filtri "oppure" (or)
 *
 * @var string OPERATOR_OR operatore "oppure"
 */
defined('OPERATOR_OR') or define("OPERATOR_OR", '$or');

/**
 * Operatore aggregatore di filtri "e" (and)
 *
 * @var string OPERATOR_AND operatore "and"
 */
defined('OPERATOR_AND') or define("OPERATOR_AND", '$and');

/**
 * Operatore filtro "uguale a"
 *
 * @var string OPERATOR_EQUAL operatore "uguale a"
 */
defined('OPERATOR_EQUAL') or define("OPERATOR_EQUAL", '$eq');

/**
 * Operatore filtro "diverso da"
 *
 * @var string OPERATOR_NOT_EQUAL operatore "diverso da"
 */
defined('OPERATOR_NOT_EQUAL') or define("OPERATOR_NOT_EQUAL", '$ne');

/**
 * Operatore filtro "inizia con"
 *
 * @var string OPERATOR_STARTS_WITH operatore "inizia con"
 */
defined('OPERATOR_STARTS_WITH') or define("OPERATOR_STARTS_WITH", '$startsWith');

/**
 * Operatore filtro "finisce con"
 *
 * @var string OPERATOR_ENDS_WITH operatore "finisce con"
 */
defined('OPERATOR_ENDS_WITH') or define("OPERATOR_ENDS_WITH", '$endsWith');

/**
 * Operatore filtro "contiene"
 *
 * @var string OPERATOR_CONTAINS operatore "contiene"
 */
defined('OPERATOR_CONTAINS') or define("OPERATOR_CONTAINS", '$contains');

/**
 * Operatore filtro "non contiene"
 *
 * @var string OPERATOR_NOT_CONTAINS operatore "non contiene"
 */
defined('OPERATOR_NOT_CONTAINS') or define("OPERATOR_NOT_CONTAINS", '$notContains');

/**
 * Operatore filtro "in"
 *
 * @var string OPERATOR_IN operatore "in"
 */
defined('OPERATOR_IN') or define("OPERATOR_IN", '$in');

/**
 * Operatore filtro "not in"
 *
 * @var string OPERATOR_NOT_IN operatore "not in"
 */
defined('OPERATOR_NOT_IN') or define("OPERATOR_NOT_IN", '$notIn');

/**
 * Operatore filtro "minore di"
 *
 * @var string OPERATOR_LESS_THAN operatore "minore di"
 */
defined('OPERATOR_LESS_THAN') or define("OPERATOR_LESS_THAN", '$lt');

/**
 * Operatore filtro "minore o uguale di"
 *
 * @var string OPERATOR_LESS_THAN_OR_EQUAL operatore "minore o uguale di"
 */
defined('OPERATOR_LESS_THAN_OR_EQUAL') or define("OPERATOR_LESS_THAN_OR_EQUAL", '$lte');

/**
 * Operatore filtro "maggiore di"
 *
 * @var string OPERATOR_GREATER_THAN operatore "maggiore di"
 */
defined('OPERATOR_GREATER_THAN') or define("OPERATOR_GREATER_THAN", '$gt');

/**
 * Operatore filtro "maggiore o uguale di"
 *
 * @var string OPERATOR_GREATER_THAN_OR_EQUAL operatore "maggiore o uguale di"
 */
defined('OPERATOR_GREATER_THAN_OR_EQUAL') or define("OPERATOR_GREATER_THAN_OR_EQUAL", '$gte');

/**
 * Operatore filtro "is null"
 *
 * @var string OPERATOR_IS_NULL operatore "is null"
 */
defined('OPERATOR_IS_NULL') or define("OPERATOR_IS_NULL", '$null');

/**
 * Operatore filtro "is not null"
 *
 * @var string OPERATOR_IS_NOT_NULL operatore "is not null"
 */
defined('OPERATOR_IS_NOT_NULL') or define("OPERATOR_IS_NOT_NULL", '$notNull');

/**
 * Tipologia di case "camelCase"
 *
 * @var string CAMEL_CASE tipo case camelCase
 */
defined('CAMEL_CASE') or define("CAMEL_CASE", 'camelCase');

/**
 * Tipologia di case "PascalCase"
 *
 * @var string PASCAL_CASE tipo case PascalCase
 */
defined('PASCAL_CASE') or define("PASCAL_CASE", 'PascalCase');

/**
 * Tipologia di case "snake_case"
 *
 * @var string SNAKE_CASE tipo case snake_case
 */
defined('SNAKE_CASE') or define("SNAKE_CASE", 'snake_case');

/**
 * Tipologia di case "kebab-case"
 *
 * @var string KEBAB_CASE tipo case kebab-case
 */
defined('KEBAB_CASE') or define("KEBAB_CASE", 'kebab-case');

/**
 * Case di default
 *
 * @var string DEFAULT_CASE tipo case di default
 */
defined('DEFAULT_CASE') or define("DEFAULT_CASE", CAMEL_CASE);

/**
 * Formato data-ora evento AMQP
 *
 * @var string EVENT_DATE_TIME_FORMAT Formato data-ora evento
 */
defined('EVENT_DATE_TIME_FORMAT') or define("EVENT_DATE_TIME_FORMAT", 'Y-m-d H:i:s');

/**
 * Prefisso identificativo univoco eventi AMQP
 *
 * @var string EVENT_ID_PREFIX Prefisso identificativo univoco eventi AMQP
 */
defined('EVENT_ID_PREFIX') or define("EVENT_ID_PREFIX", 'EVENT');

/**
 * Lunghezza identificativo univoco eventi AMQP
 * Si raccomanda di valorizzare questa costante con un valore numerico che
 * sia sempre superiore di almeno 15 caratteri dal numero di caratteri impostati
 * nel prefisso EVENT_ID_PREFIX
 *
 * @var int EVENT_ID_LENGTH Lunghezza identificativo univoco eventi AMQP
 */
defined('EVENT_ID_LENGTH') or define("EVENT_ID_LENGTH", 32);

/**
 * Parola chiave per proprietà di entità in sola lettura
 * in alcuni casi le entità potrebbero essere "arricchite" da proprietà readOnly
 * che quindi non fanno parte del corredo di field che definiscono una nuova entità
 * ma fanno comodo in fase di fruizione, lettura ed utilizzo.
 *
 * @var string READONLY_PROPERTY Nota PSR12 rende una proprietà di sola lettura
 */
defined('READONLY_PROPERTY') or define("READONLY_PROPERTY", '@global readonly');

/**
 * Questa costante permette di attivare o disabilitare la "decorazione" dell'output.
 * Se la costante DECORATE_OUTPUT viene impostata a false le funzionalità di replace
 * contenute nella classe Mikro\Tools\OutputDecorator non verranno eseguite.
 *
 * @var string DECORATE_OUTPUT Flag attivazione / disattivazione decoratore output
 */
defined('DECORATE_OUTPUT') or define("DECORATE_OUTPUT", true);

/**
 * L'output dei controller è un oggetto Response. Questo oggetto response è di tipo
 * "stringable" e spesso la sua rappresentazione è STRINGA. I response passano dalle
 * logiche più profonde di Mikro e spesso può essere complesso dinamicizzare alcuni
 * aspetti importanti specialmente in ambito relazioni HAETOAS. Questa costante rap
 * presenta il prefisso di un selettore di una proprietà placeholder nell'output
 * stringa di un response.
 *
 * @var string DECORATOR_PREFIX Stringa prefisso selettori placeholder output
 */
defined('DECORATOR_PREFIX') or define("DECORATOR_PREFIX", '{');

/**
 * L'output dei controller è un oggetto Response. Questo oggetto response è di tipo
 * "stringable" e spesso la sua rappresentazione è STRINGA. I response passano dalle
 * logiche più profonde di Mikro e spesso può essere complesso dinamicizzare alcuni
 * aspetti importanti specialmente in ambito relazioni HAETOAS. Questa costante rap
 * presenta il suffisso di un selettore di una proprietà placeholder nell'output
 * stringa di un response.
 *
 * @var string DECORATOR_SUFFIX Stringa suffisso selettori placeholder output
 */
defined('DECORATOR_SUFFIX') or define("DECORATOR_SUFFIX", '}');
