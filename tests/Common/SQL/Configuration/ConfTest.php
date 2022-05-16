<?php

namespace MikroTest\Common\SQL\Configuration;

use PHPUnit\Framework\TestCase;
use Mikro\Common\SQL\Configuration\Conf;

class ConfTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero parametri
     */
    public function testCreationAndGetProperties()
    {
        
        $host = '127.222.124.291';
        $port = 1923;
        $username = 'pipp0';
        $password = 'pipp@cia1';
        $database = 'joker';

        $conf = new Conf($host, $port, $username, $password, $database);

        $this->assertEquals($host, $conf->getHost());
        $this->assertEquals($port, $conf->getPort());
        $this->assertEquals($username, $conf->getUsername());
        $this->assertEquals($password, $conf->getPassword());
        $this->assertEquals($database, $conf->getDatabase());
    }

    /**
     * Verifica corretta empty creation assegnazione e recupero parametri
     */
    public function testEmptyCreationAndAssignmentAndGetProperties()
    {
        
        $host = '127.222.124.291';
        $port = 1923;
        $username = 'pipp0';
        $password = 'pipp@cia1';
        $database = 'joker';

        $conf = new Conf();
        $this->assertEquals(null, $conf->getHost());
        $this->assertEquals(null, $conf->getPort());
        $this->assertEquals(null, $conf->getUsername());
        $this->assertEquals(null, $conf->getPassword());
        $this->assertEquals(null, $conf->getDatabase());

        $conf->setHost($host);
        $conf->setPort($port);
        $conf->setUsername($username);
        $conf->setPassword($password);
        $conf->setDatabase($database);

        $this->assertEquals($host, $conf->getHost());
        $this->assertEquals($port, $conf->getPort());
        $this->assertEquals($username, $conf->getUsername());
        $this->assertEquals($password, $conf->getPassword());
        $this->assertEquals($database, $conf->getDatabase());
    }
}
