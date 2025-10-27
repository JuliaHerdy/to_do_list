<?php

namespace Src\UseCase\Pedido;

use Src\Database\Database;

class PedidoListUseCase
{
    public function __construct(protected Database $database)
    {
    }

    public function execute(): array
    {
        $resultPedidosList = pg_query($this->database->getConnection(), "select pedidos.id, cliente.name, pedidos.data_pedido, pedidos.valor_final from cliente inner join pedidos on cliente.id = pedidos.client_id;");
        return pg_fetch_all($resultPedidosList);
    }
}