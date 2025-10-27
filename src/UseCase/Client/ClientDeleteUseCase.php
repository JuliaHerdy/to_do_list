<?php

namespace Src\UseCase\Client;

use Src\Database\Database;

class ClientDeleteUseCase
{
    public function __construct(protected Database $database)
    {
    }

    public function execute(int $id): bool
    {
        $query = "DELETE FROM cliente WHERE id = $1";
        $result = pg_query_params($this->database->getConnection(), $query, [$id]);

        if ($result) {
            return true;
        }
        return false;
    }
}