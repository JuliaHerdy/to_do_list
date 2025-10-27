<?php

namespace Src\UseCase\Client;

use Src\Database\Database;

class ClientListUseCase
{
    public function __construct(protected Database $database)
    {
    }

    public function execute(): array
    {
        $resultClientList = pg_query($this->database->getConnection(), "SELECT * FROM cliente ORDER BY id asc");
        return pg_fetch_all($resultClientList);
    }
}