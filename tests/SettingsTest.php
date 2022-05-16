<?php

namespace MikroTest;

use PHPUnit\Framework\TestCase;
use Mikro\Settings;
use Mikro\Exceptions\ServiceNameException;

class SettingsTest extends TestCase
{
    /**
     * Verifica corretto set and get Hateoas YAML directory
     */
    public function testSetAndGetHateoasYamlDir()
    {
        Settings::addHateoasYamlDirPath('/prova/percorso', 'Prova\Prefisso\Namespace');
        $this->assertEquals(['Prova\Prefisso\Namespace' => '/prova/percorso'], Settings::getHateoasYamlDirsPaths());
        $this->resetSettings();
    }

    /**
     * Verifica corretto set and get Name Space controllers
     */
    public function testSetAndGetControllersNameSpaces()
    {
        Settings::setControllersNameSpaces(['MikroTest\Assets\Classes']);
        $this->assertEquals(['MikroTest\Assets\Classes'], Settings::getControllersNameSpaces());

        Settings::setControllersNameSpaces([]);
        $this->assertEquals([], Settings::getControllersNameSpaces());

        Settings::addControllersNameSpace('MikroTest\Assets\Classes');
        $this->assertEquals(['MikroTest\Assets\Classes'], Settings::getControllersNameSpaces());
        $this->resetSettings();
    }

    /**
     * Verifica corretto set and get nome servizio
     */
    public function testSetAndGetServiceName()
    {
        $this->assertEquals('Mikro', Settings::getServiceName());

        Settings::setServiceName('Prova002');
        $this->assertEquals('Prova002', Settings::getServiceName());

        Settings::setServiceName('A12345678910');
        $this->assertEquals('A12345678910', Settings::getServiceName());

        $this->expectException(ServiceNameException::class);
        Settings::setServiceName('Prova002 s');

        $this->expectException(ServiceNameException::class);
        Settings::setServiceName('129A192392');
        $this->resetSettings();
    }

    /**
     * Verifica parsing file configurazione settings YAML
     */
    public function testYml()
    {
        Settings::yaml(__DIR__ . '/Assets/settings.yml');
        $this->assertEquals('TestNomeServizio', Settings::getServiceName());
        $this->assertEquals(new \Mikro\Cache\Cache, Settings::getCache());
        $this->assertEquals(KEBAB_CASE, Settings::getRepositoryFieldCase());
        $this->assertEquals(['Controller\001', 'Controller\002'], Settings::getControllersNameSpaces());
        $this->assertEquals(['Model\001', 'Model\002'], Settings::getModelsNameSpaces());
        $this->assertEquals(['Repo\001', 'Repo\002'], Settings::getRepositoriesNameSpaces());
        $this->assertEquals(['Consumer\001', 'Consumer\002'], Settings::getConsumersNameSpaces());
        $this->assertEquals(['Publisher\001', 'Publisher\002'], Settings::getPublishersNameSpaces());
        $this->resetSettings();
    }

    /**
     * Metodo di reset default dati Settings
     */
    private function resetSettings()
    {
        Settings::setServiceName('Mikro');
        Settings::setControllersNameSpaces([]);
        Settings::setModelsNameSpaces([]);
        Settings::setRepositoriesNameSpaces([]);
        Settings::resetHateoasYamlDirsPaths();
        Settings::setRepositoryFieldCase(DEFAULT_CASE);
        Settings::setCache(null);
        Settings::setCacheDir(DEFAULT_CACHE_DIR);
    }
}
