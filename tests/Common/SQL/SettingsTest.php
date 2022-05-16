<?php

namespace MikroTest\Common\SQL;

use PHPUnit\Framework\TestCase;
use Mikro\Common\SQL\Configuration\Conf;
use Mikro\Common\SQL\Settings;

class SettingsTest extends TestCase
{
    /**
     * Verifica assegnazione statica proprietà per proprietà
     */
    public function testAssignmentSingleProperties()
    {
        Settings::setHost('192.168.2.191');
        Settings::setPort(3098);
        Settings::setUsername('federico');
        Settings::setPassword('f3d3r1c0!');
        Settings::setDatabase('micros');

        $conf = Settings::getConf();
        $this->assertInstanceOf('Mikro\Common\SQL\Configuration\ConfInterface', $conf);
        $this->assertEquals('192.168.2.191', $conf->getHost());
        $this->assertEquals(3098, $conf->getPort());
        $this->assertEquals('federico', $conf->getUsername());
        $this->assertEquals('f3d3r1c0!', $conf->getPassword());
        $this->assertEquals('micros', $conf->getDatabase());

        $conf2 = Settings::getConf('clx');
        $this->assertNull($conf2);
    }

    /**
     * Verifica assegnazione statica da istanza Conf
     */
    public function testAssignmentFromInstance()
    {
        $conf = new Conf();
        $conf->setHost('192.168.2.191');
        $conf->setPort(3098);
        $conf->setUsername('federico');
        $conf->setPassword('f3d3r1c0!');
        $conf->setDatabase('micros');

        Settings::setConf($conf);
        $conf = Settings::getConf();
        $this->assertInstanceOf('Mikro\Common\SQL\Configuration\ConfInterface', $conf);
        $this->assertEquals('192.168.2.191', $conf->getHost());
        $this->assertEquals(3098, $conf->getPort());
        $this->assertEquals('federico', $conf->getUsername());
        $this->assertEquals('f3d3r1c0!', $conf->getPassword());
        $this->assertEquals('micros', $conf->getDatabase());

        $conf2 = Settings::getConf('clx');
        $this->assertNull($conf2);
    }

    /**
     * Verifica assegnazione statica di più istanze Conf
     */
    public function testMultipleAssignment()
    {
        $confUser = new Conf();
        $confUser->setHost('192.168.2.191');
        $confUser->setPort(3098);
        $confUser->setUsername('federico');
        $confUser->setPassword('f3d3r1c0!');
        $confUser->setDatabase('utenti');

        $confProduct = new Conf();
        $confProduct->setHost('192.168.1.100');
        $confProduct->setPort(9012);
        $confProduct->setUsername('biondi');
        $confProduct->setPassword('b1ondi!');
        $confProduct->setDatabase('prodotti');

        Settings::setConf($confUser, 'utenti');
        Settings::setConf($confProduct, 'prodotti');

        $conf = Settings::getConf('utenti');
        $this->assertInstanceOf('Mikro\Common\SQL\Configuration\ConfInterface', $conf);
        $this->assertEquals('192.168.2.191', $conf->getHost());
        $this->assertEquals(3098, $conf->getPort());
        $this->assertEquals('federico', $conf->getUsername());
        $this->assertEquals('f3d3r1c0!', $conf->getPassword());
        $this->assertEquals('utenti', $conf->getDatabase());

        $conf2 = Settings::getConf('prodotti');
        $this->assertInstanceOf('Mikro\Common\SQL\Configuration\ConfInterface', $conf);
        $this->assertEquals('192.168.1.100', $conf2->getHost());
        $this->assertEquals(9012, $conf2->getPort());
        $this->assertEquals('biondi', $conf2->getUsername());
        $this->assertEquals('b1ondi!', $conf2->getPassword());
        $this->assertEquals('prodotti', $conf2->getDatabase());

        $conf3 = Settings::getConf('clx');
        $this->assertNull($conf3);
    }
}
