<?php

use Src\Controller\Client\ClientController;

$clientController = new ClientController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['action'] == 'cliente') {
    $clientController->create();
}

if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];
    $clientController->delete($id);
}

$clientes = $clientController->list();

?>

<h1>Cadastro de Cliente</h1>

<form method="POST" action="?action=cliente">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    <button type="submit">Salvar</button>
</form>

<h2>Lista de Clientes</h2>

<?php if (!empty($clientes)) { ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($clientes as $row) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td>
                    <a class="delete-btn" href="?delete=<?= urlencode($row['id']) ?>" onclick="return confirm('Tem certeza que deseja excluir este cliente?');">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>Nenhum cliente cadastrado.</p>
<?php } ?>

