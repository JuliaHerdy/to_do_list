<?php

namespace Src\Controller\Pedido;

use Src\Database\Database;
use Src\UseCase\Client\ClientListUseCase;
use Src\UseCase\Pedido\PedidoCreateUseCase;
use Src\UseCase\Pedido\PedidoDeleteUseCase;
use Src\UseCase\Pedido\PedidoListUseCase;

class PedidoController
{
    public function __construct(protected Database $database)
    {
    }

    public function create(): void
    {
        $clientId = (int)$_POST["client_id"];
        $amount = (float)$_POST["amount"];

        $clientes = new ClientListUseCase($this->database)->execute();

        $clientExists = false;
        foreach ($clientes as $row) {
            if ($row['id'] == $clientId) {
                $clientExists = true;
                break;
            }
        }

        if ($clientExists) {
            if (new PedidoCreateUseCase($this->database)->execute($clientId, $amount)) {
                echo "Pedido cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar pedido: " . $this->database->getErros();
            }
        } else {
            echo "Cliente selecionado é inválido!";
        }
    }

    public function delete(int $id): void
    {
        if (new PedidoDeleteUseCase($this->database)->execute($id)) {
            echo "Pedido excluído com sucesso!";
        } else {
            echo "Erro ao excluir Pedido: " . $this->database->getErros();
        }
    }

    public function list(): array
    {
        return new PedidoListUseCase($this->database)->execute();
    }
}