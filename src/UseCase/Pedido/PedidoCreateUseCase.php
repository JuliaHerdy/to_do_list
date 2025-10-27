<?php

namespace Src\UseCase\Pedido;

use Src\Database\Database;

class PedidoCreateUseCase
{
    public function __construct(protected Database $database)
    {
    }

    public function execute(int $clientId, float $amount): bool
    {
        $query = "INSERT INTO pedidos (client_id, data_pedido, valor_final) VALUES ($1, $2, $3)";
        $result = pg_query_params($this->database->getConnection(), $query, [$clientId, date("Y-m-d"), $amount]);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}