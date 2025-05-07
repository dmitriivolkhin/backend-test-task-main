<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure;

use Redis;
use RedisException;

class ConnectorFacade
{
    private string $host;
    private int $port = 6379;
    private ?string $password = null;
    private ?int $dbindex = null;

    private $connector;

    public function __construct($host, $port, $password, $dbindex)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->dbindex = $dbindex;

        $this->build();
    }

    protected function build(): void
    {
        $redis = new Redis();

        try {
            $isConnected = $redis->isConnected();
            if (! $isConnected && $redis->ping('Pong')) {
                $isConnected = $redis->connect(
                    $this->host,
                    $this->port,
                );
            }
        } catch (RedisException) {
        }

        if ($isConnected) {
            $redis->auth($this->password);
            $redis->select($this->dbindex);
            $this->connector = new Connector($redis);
        }
    }

    public function getConnector(): Connector
    {
        return $this->connector;
    }
}
