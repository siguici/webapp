<?php namespace Ske\Util;

class Ftp {
    public function __construct(string $host, int $port = 21, int $timeout = 90, bool $secure = false) {
        $secure ? $this->sslConnect($host, $port, $timeout) : $this->connect($host, $port, $timeout);
    }

    protected $connection;

    public function connect(string $host, int $port = 21, int $timeout = 90): void {
        if (!($this->connection = ftp_connect($host, $port, $timeout)))
            throw new \Exception("Failed to connect to $host:$port");
    }

    public function sslConnect(string $host, int $port = 21, int $timeout = 90): void {
        if (!($this->connection = ftp_ssl_connect($host, $port, $timeout)))
            throw new \Exception("SSL connection failure to $host:$port");
    }

    public function __call(string $name, array $arguments): mixed {
        if (!$this->connection)
            throw new \Exception("FTP connection not established");

        if (!preg_match('/^login|pasv|chdir|cdup|chmod|delete|rename|rmdir|mkdir|nlist|pwd|systype|site|size|mdtm|chgrp|chown|get|put|rawlist|raw$/i', $name))
            throw new \Exception("Invalid FTP command: $name");

        $name = 'ftp_' . strtolower($name);
        return $name($this->connection, ...$arguments);
    }

    public function close() {
        ftp_close($this->connection);
    }

    public function __destruct() {
        $this->close();
    }
}