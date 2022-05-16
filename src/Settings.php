<?php

/**
 * Settings.php
 * Mikro\Settings
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro;

use Mikro\Cache\CacheInterface;
use Mikro\Exceptions\ServiceNameException;
use Symfony\Component\Yaml\Yaml;

/**
 * Implementazione concreta gestore di configurazioni
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class Settings
{
    /**
     * Nome servizio
     *
     * @var string $serviceName Nome servizio
     */
    private static string $serviceName = DEFAULT_SERVICE_NAME;

    /**
     * Collezione di percorsi radice Name Space ( PSR-4 ) in cui sono presenti
     * implementazioni concrete dell'interfaccia Mikro\Controller\ControllerInterface
     *
     * @var array $controllersNameSpaces Array posizionale di percorsi Name Space PSR-4
     */
    private static array $controllersNameSpaces = [];

    /**
     * Collezione di percorsi radice Name Space ( PSR-4 ) in cui sono presenti
     * implementazioni concrete dell'interfaccia Mikro\Model\ModelInterface
     *
     * @var array $modelsNameSpaces Array posizionale di percorsi Name Space PSR-4
     */
    private static array $modelsNameSpaces = [];

    /**
     * Collezione di percorsi radice Name Space ( PSR-4 ) in cui sono presenti
     * implementazioni concrete dell'interfaccia Mikro\Repository\RepositoryInterface
     *
     * @var array $repositoriesNameSpaces Array posizionale di percorsi Name Space PSR-4
     */
    private static array $repositoriesNameSpaces = [];

    /**
     * Collezione di percorsi radice Name Space ( PSR-4 ) in cui sono presenti
     * implementazioni concrete dell'interfaccia Mikro\Event\Consumer\ConsumerInterface
     *
     * @var array $consumersNameSpaces Array posizionale di percorsi Name Space PSR-4
     */
    private static array $consumersNameSpaces = [];

    /**
     * Collezione di percorsi radice Name Space ( PSR-4 ) in cui sono presenti
     * implementazioni concrete dell'interfaccia Mikro\Event\Publisher\PublisherInterface
     *
     * @var array $publishersNameSpaces Array posizionale di percorsi Name Space PSR-4
     */
    private static array $publishersNameSpaces = [];

    /**
     * Percorsi cartelle contenenti i file YAML HATEOAS
     *
     * @var array $hateoasYamlDirsPaths Array di percorsi cartella contenente file YAML HATEOAS
     */
    private static array $hateoasYamlDirsPaths = [];

    /**
     * Tipologia di case utilizzato nel design della struttura del repository
     *
     * @var string $repositoryFieldCase Tipologia di case: CAMEL_CASE, PASCAL_CASE, SNAKE_CASE e KEBAB_CASE
     */
    private static string $repositoryFieldCase = DEFAULT_CASE;

    /**
     * Istanza gestore di cache
     * Quando è presente un'istanza di cache il sistema utilizza l'istanza per
     * leggere e scrivere dati nei processi di discovery file-system e name-space PSR-4.
     *
     * N.B. Se questa proprietà è impostata a null la cache è disabilitata.
     *
     * @var ?CacheInterface $cache Istanza gestore Cache
     */
    private static ?CacheInterface $cache = null;

    /**
     * Percorso cartella destinazione file cache integrata
     *
     * @var string $cacheDir Percorso cartella di root file di cache integrata
     */
    private static string $cacheDir = DEFAULT_CACHE_DIR;

    /**
     * Assegnazione nome servizio
     *
     * @param string $serviceName Nome servizio
     *
     * @return void
     */
    public static function setServiceName(string $serviceName): void
    {
        if (preg_match('/^[A-Za-z]{1}[A-Za-z0-9]+$/', $serviceName) == false) {
            self::throwServiceNameException($serviceName);
        }
        self::$serviceName = $serviceName;
    }

    /**
     * Assegnazione collezione di percorsi PSR-4
     *
     * @param array $nameSpaces Array posizionale di percorsi Name Space radice PSR-4
     *
     * @return void
     */
    public static function setControllersNameSpaces(array $nameSpaces): void
    {
        self::$controllersNameSpaces = $nameSpaces;
    }

    /**
     * Inserimento percorso PSR-4 alla collezione
     *
     * @param string $nameSpace Name Space radice PSR-4
     *
     * @return void
     */
    public static function addControllersNameSpace(string $nameSpace): void
    {
        if (in_array($nameSpace, self::$controllersNameSpaces)) {
            return;
        }
        self::$controllersNameSpaces[] = $nameSpace;
    }

    /**
     * Assegnazione collezione di percorsi PSR-4
     *
     * @param array $nameSpaces Array posizionale di percorsi Name Space radice PSR-4
     *
     * @return void
     */
    public static function setModelsNameSpaces(array $nameSpaces): void
    {
        self::$modelsNameSpaces = $nameSpaces;
    }

    /**
     * Inserimento percorso PSR-4 alla collezione
     *
     * @param string $nameSpace Name Space radice PSR-4
     *
     * @return void
     */
    public static function addModelsNameSpace(string $nameSpace): void
    {
        if (in_array($nameSpace, self::$modelsNameSpaces)) {
            return;
        }
        self::$modelsNameSpaces[] = $nameSpace;
    }

    /**
     * Assegnazione collezione di percorsi PSR-4
     *
     * @param array $nameSpaces Array posizionale di percorsi Name Space radice PSR-4
     *
     * @return void
     */
    public static function setRepositoriesNameSpaces(array $nameSpaces): void
    {
        self::$repositoriesNameSpaces = $nameSpaces;
    }

    /**
     * Inserimento percorso PSR-4 alla collezione
     *
     * @param string $nameSpace Name Space radice PSR-4
     *
     * @return void
     */
    public static function addRepositoriesNameSpace(string $nameSpace): void
    {
        if (in_array($nameSpace, self::$repositoriesNameSpaces)) {
            return;
        }
        self::$repositoriesNameSpaces[] = $nameSpace;
    }

    /**
     * Assegnazione collezione di percorsi PSR-4
     *
     * @param array $nameSpaces Array posizionale di percorsi Name Space radice PSR-4
     *
     * @return void
     */
    public static function setConsumersNameSpaces(array $nameSpaces): void
    {
        self::$consumersNameSpaces = $nameSpaces;
    }

    /**
     * Inserimento percorso PSR-4 alla collezione
     *
     * @param string $nameSpace Name Space radice PSR-4
     *
     * @return void
     */
    public static function addConsumersNameSpace(string $nameSpace): void
    {
        if (in_array($nameSpace, self::$consumersNameSpaces)) {
            return;
        }
        self::$consumersNameSpaces[] = $nameSpace;
    }

    /**
     * Assegnazione collezione di percorsi PSR-4
     *
     * @param array $nameSpaces Array posizionale di percorsi Name Space radice PSR-4
     *
     * @return void
     */
    public static function setPublishersNameSpaces(array $nameSpaces): void
    {
        self::$publishersNameSpaces = $nameSpaces;
    }

    /**
     * Inserimento percorso PSR-4 alla collezione
     *
     * @param string $nameSpace Name Space radice PSR-4
     *
     * @return void
     */
    public static function addPublishersNameSpace(string $nameSpace): void
    {
        if (in_array($nameSpace, self::$publishersNameSpaces)) {
            return;
        }
        self::$publishersNameSpaces[] = $nameSpace;
    }

    /**
     * Assegnazione percorso cartella contenente file YAML HATEOAS
     *
     * Poniamo che nell'implementazione di questo pacakge il developer crei un psr-4
     * {
     *   "Animali\\": "src/"
     * }
     *
     * Nella directory "/var/www/progettodemo/yaml/animali"
     *
     * Potrebbero esserci le definizioni hateoas dei seguenti animali:
     *
     * Pinguino.yml -> Che per il processore HATEOAS sarà Animali\Pinguino
     * Cane.yml -> Che per il processore HATEOAS sarà Animali\Cane
     * Gatto.yml -> Che per il processore HATEOAS sarà Animali\Gatto
     *
     * Quindi in questo esempio sarà necessario configurare così questa impostazione:
     *
     * Mikro\Settings::addHateoasYamlDirPath('/var/www/progettodemo/yaml/animali', 'Animali');
     *
     * @param string $hateoasYamlDirPath Percorso cartella contenente file YAML HATEOAS
     * @param string $namespacePrefix Prefisso ( Percorso Namespace di riferimento )
     *
     * @return void
     */
    public static function addHateoasYamlDirPath(string $hateoasYamlDirPath, string $namespacePrefix): void
    {
        self::$hateoasYamlDirsPaths[$namespacePrefix] = $hateoasYamlDirPath;
    }

    /**
     * Reset valori elenco file yml Hateoas
     *
     * @return void
     */
    public static function resetHateoasYamlDirsPaths(): void
    {
        self::$hateoasYamlDirsPaths = [];
    }

    /**
     * Assegnazione tipologia di case utilizzato nel design della struttura del repository
     *
     * @param string $repositoryFieldCase Tipologia di case utilizzato nel design della struttura del repository
     *
     * @return void
     */
    public static function setRepositoryFieldCase(string $repositoryFieldCase): void
    {
        if (!in_array($repositoryFieldCase, [CAMEL_CASE, PASCAL_CASE, SNAKE_CASE, KEBAB_CASE])) {
            return;
        }
        self::$repositoryFieldCase = $repositoryFieldCase;
    }

    /**
     * Assegnazione gestore di cache
     *
     * @param ?CacheInterface $cache Istanza CacheInterface
     *
     * @return void
     */
    public static function setCache(?CacheInterface $cache): void
    {
        self::$cache = $cache;
    }

    /**
     * Assegnazione percorso cartella destinazione file cache integrata
     *
     * @param string $cacheDir Percorso cartella di root file di cache integrata
     *
     * @return void
     */
    public static function setCacheDir(string $cacheDir): void
    {
        if (!is_dir($cacheDir)) {
            return;
        }
        self::$cacheDir = $cacheDir;
    }

    /**
     * Recupero nome servizio
     *
     * @return string
     */
    public static function getServiceName(): string
    {
        return self::$serviceName;
    }

    /**
     * Recupero collezione di percorsi PSR-4 in cui risiedono implementazioni concrete
     * di Mikro\Controller\ControllerInterface
     *
     * @return array
     */
    public static function getControllersNameSpaces(): array
    {
        return self::$controllersNameSpaces;
    }

    /**
     * Recupero collezione di percorsi PSR-4 in cui risiedono implementazioni concrete
     * di Mikro\Model\ModelInterface
     *
     * @return array
     */
    public static function getModelsNameSpaces(): array
    {
        return self::$modelsNameSpaces;
    }

    /**
     * Recupero collezione di percorsi PSR-4 in cui risiedono implementazioni concrete
     * di Mikro\Repository\RepositoryInterface
     *
     * @return array
     */
    public static function getRepositoriesNameSpaces(): array
    {
        return self::$repositoriesNameSpaces;
    }

    /**
     * Recupero collezione di percorsi PSR-4 in cui risiedono implementazioni concrete
     * di Mikro\Event\Consumer\ConsumerInterface
     *
     * @return array
     */
    public static function getConsumersNameSpaces(): array
    {
        return self::$consumersNameSpaces;
    }

    /**
     * Recupero collezione di percorsi PSR-4 in cui risiedono implementazioni concrete
     * di Mikro\Event\Publisher\PublisherInterface
     *
     * @return array
     */
    public static function getPublishersNameSpaces(): array
    {
        return self::$publishersNameSpaces;
    }

    /**
     * Recupero percorsi cartelle contenenti i file YAML HATEOAS
     *
     * @return array
     */
    public static function getHateoasYamlDirsPaths(): array
    {
        return self::$hateoasYamlDirsPaths;
    }

    /**
     * Recupero tipologia di case utilizzato nel design della struttura del repository
     *
     * @return string
     */
    public static function getRepositoryFieldCase(): string
    {
        return self::$repositoryFieldCase;
    }

    /**
     * Recupero istanza gestore di cache
     *
     * @return ?CacheInterface
     */
    public static function getCache(): ?CacheInterface
    {
        return self::$cache;
    }

    /**
     * Recupero percorso cartella destinazione file cache integrata
     *
     * @return string
     */
    public static function getCacheDir(): string
    {
        return self::$cacheDir;
    }

    /**
     * Processo di assegnazione parametri di configurazione da file yaml
     *
     * @param string $yamlFilePath Percorso file yaml
     *
     * @return void
     */
    public static function yaml(string $yamlFilePath): void
    {
        $settings = Yaml::parseFile($yamlFilePath);

        $serviceName = isset($settings['serviceName']) ? (string)$settings['serviceName'] : null;
        if (!is_null($serviceName)) {
            self::setServiceName($serviceName);
        }

        $controllersNameSpaces = isset($settings['controllersNameSpaces']) ? $settings['controllersNameSpaces'] : [];
        $controllersNameSpaces = !is_array($controllersNameSpaces) ? [] : $controllersNameSpaces;
        foreach ($controllersNameSpaces as $nameSpace) {
            self::addControllersNameSpace($nameSpace);
        }

        $modelsNameSpaces = isset($settings['modelsNameSpaces']) ? $settings['modelsNameSpaces'] : [];
        $modelsNameSpaces = !is_array($modelsNameSpaces) ? [] : $modelsNameSpaces;
        foreach ($modelsNameSpaces as $nameSpace) {
            self::addModelsNameSpace($nameSpace);
        }

        $repositoriesNameSpaces = isset($settings['repositoriesNameSpaces']) ? $settings['repositoriesNameSpaces'] : [];
        $repositoriesNameSpaces = !is_array($repositoriesNameSpaces) ? [] : $repositoriesNameSpaces;
        foreach ($repositoriesNameSpaces as $nameSpace) {
            self::addRepositoriesNameSpace($nameSpace);
        }

        $consumersNameSpaces = isset($settings['consumersNameSpaces']) ? $settings['consumersNameSpaces'] : [];
        $consumersNameSpaces = !is_array($consumersNameSpaces) ? [] : $consumersNameSpaces;
        foreach ($consumersNameSpaces as $nameSpace) {
            self::addConsumersNameSpace($nameSpace);
        }

        $publishersNameSpaces = isset($settings['publishersNameSpaces']) ? $settings['publishersNameSpaces'] : [];
        $publishersNameSpaces = !is_array($publishersNameSpaces) ? [] : $publishersNameSpaces;
        foreach ($publishersNameSpaces as $nameSpace) {
            self::addPublishersNameSpace($nameSpace);
        }

        $hateoasYamlDirsPaths = isset($settings['hateoasYamlDirsPaths']) ? $settings['hateoasYamlDirsPaths'] : [];
        $hateoasYamlDirsPaths = !is_array($hateoasYamlDirsPaths) ? [] : $hateoasYamlDirsPaths;
        foreach ($hateoasYamlDirsPaths as $hateoasItem) {
            if (!is_array($hateoasItem)) {
                continue;
            }
            $prefix = isset($hateoasItem['prefix']) ? (string)$hateoasItem['prefix'] : null;
            $dirPath = isset($hateoasItem['dirPath']) ? (string)$hateoasItem['dirPath'] : null;
            $dirPath = is_dir($dirPath) ? $dirPath : null;
            if (is_null($prefix) || is_null($dirPath)) {
                continue;
            }
            self::addHateoasYamlDirPath($dirPath, $prefix);
        }

        $repositoryFieldCase = isset($settings['repositoryFieldCase']) ? $settings['repositoryFieldCase'] : null;
        switch ($repositoryFieldCase) {
            case "camel":
                self::setRepositoryFieldCase(CAMEL_CASE);
                break;
            case "pascal":
                self::setRepositoryFieldCase(PASCAL_CASE);
                break;
            case "snake":
                self::setRepositoryFieldCase(SNAKE_CASE);
                break;
            case "kebab":
                self::setRepositoryFieldCase(KEBAB_CASE);
                break;
            case "default":
                self::setRepositoryFieldCase(DEFAULT_CASE);
                break;
        }

        $cache = isset($settings['cache']) ? $settings['cache'] : null;
        if ($cache == "system") {
            $class = SYSTEM_CACHE;
            self::setCache(new $class());
            $cacheDir = isset($settings['cacheDir']) ? $settings['cacheDir'] : null;
            if (!is_null($cacheDir) && $cacheDir != 'default') {
                self::setCacheDir($cacheDir);
            }
        } elseif (!is_null($cache) && class_exists($cache)) {
            self::setCache(new $cache());
        }
    }

    /**
     * Avvio eccezione NotSetException
     *
     * @param string $serviceName Nome servizio non valido
     *
     * @return void
     */
    private static function throwServiceNameException(string $serviceName): void
    {
        $message[] = 'E\' stato impossibile impostare il nome del servizio come indicato';
        $message[] = sprintf('la stringa "%s" non e\' valida.', $serviceName);
        $message[] = 'Il nome del servizio deve essere di almeno 2 caratteri e conforme';
        $message[] = 'al pattern ^[A-Za-z][A-Za-z0-9]+$';
        $message = implode(' ', $message);
        throw new ServiceNameException($message);
    }
}
