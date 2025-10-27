<?php

namespace Src\Controller\Client;

use Src\Database\Database;
use Src\UseCase\Client\ClientCreateUseCase;
use Src\UseCase\Client\ClientDeleteUseCase;
use Src\UseCase\Client\ClientListUseCase;

class ClientController
{
    public function __construct(protected Database $database)
    {
    }

    public function create(): void
    {
        $name = trim($_POST["nome"]);
        if ($name !== "") {
            if (new ClientCreateUseCase($this->database)->execute($name)) {
                echo "Cliente cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar cliente: " . $this->database->getErros();
            }
        } else {
            echo "Nome é Obrigatório!";
        }
    }

    public function delete(int $id): void
    {
        if (new ClientDeleteUseCase($this->database)->execute($id)) {
            echo "Cliente excluído com sucesso!";
        } else {
            echo "Erro ao excluir cliente: " . $this->database->getErros();
        }
    }

    public function list(): array
    {
        return new ClientListUseCase($this->database)->execute();
    }
}