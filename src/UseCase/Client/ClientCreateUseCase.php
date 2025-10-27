<?php

namespace Src\UseCase\Client;

use Src\Database\Database;

class ClientCreateUseCase
{
    public function __construct(protected Database $database)
    {
    }

    public function execute(string $name): bool
    {
        $query = "INSERT INTO cliente (name) VALUES ($1)";
        $result = pg_query_params($this->database->getConnection(), $query, [$name]);

        if ($result) {
            return true;
        }
        return false;
    }
}