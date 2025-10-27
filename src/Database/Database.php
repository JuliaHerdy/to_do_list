<?php

namespace Src\Database;

use PgSql\Connection;

class Database
{
    protected Connection|false $database;

    public function __construct(string $host, string $port, string $dbname, string $user, string $password)
    {
        $this->database = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
        if (! $this->database) {
            die("Erro ao se conectar no banco de dados");
        }
    }

    public function getConnection(): Connection
    {
        return $this->database;
    }

    public function getErros(): string
    {
        return pg_last_error($this->database);
    }
}