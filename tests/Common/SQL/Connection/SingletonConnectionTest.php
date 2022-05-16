<?php

namespace MikroTest\Common\SQL\Connection;

use PHPUnit\Framework\TestCase;
use Mikro\Common\SQL\Configuration\Conf;
use Mikro\Common\SQL\Connection\SingletonConnection;

class SingletonConnectionTest extends TestCase
{
    /**
     * Verifica corretta funzionalità di innesco connessione
     */
    public function testCreationInstance()
    {
        $host = '127.222.124.291';
        $port = 1923;
        $username = 'pipp0';
        $password = 'pipp@cia1';
        $database = 'joker';

        $conf = new Conf($host, $port, $username, $password, $database);
        $conn = SingletonConnection::getInstance($conf);
        $conn2 = SingletonConnection::getInstance($conf);

        $this->assertInstanceOf("Mikro\Common\SQL\Connection\ConnectionInterface", $conn);
        $this->assertSame(spl_object_id($conn), spl_object_id($conn2));
    }

    /**
     * Verifica corretta funzionalità di distruzione connessione
     */
    public function testDestoryInstance()
    {
        $host = '127.222.124.291';
        $port = 1923;
        $username = 'pipp0';
        $password = 'pipp@cia1';
        $database = 'joker';

        $conf = new Conf($host, $port, $username, $password, $database);
        $conn = SingletonConnection::getInstance($conf);
        SingletonConnection::destoryInstance();
        $conn2 = SingletonConnection::getInstance($conf);

        $this->assertInstanceOf("Mikro\Common\SQL\Connection\ConnectionInterface", $conn);
        $this->assertNotEquals(spl_object_id($conn), spl_object_id($conn2));
    }
}
