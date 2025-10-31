<?php
namespace Src\Database;

use pgsql\Connection;

class Database {
    protected Connection|false $database;

    public function __construct(string $host, string $user, string $password, string $dbname, string $port) {
        $this->database = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
        if (!$this->database) {
            die("Erro ao se conectar ao banco de dados.");
        }
    }

    public function getConnection(): Connection {
        return $this->database;
    }

    public function getError(): string {
        return pg_last_error($this->database);
    }
}