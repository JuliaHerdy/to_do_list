<?php

use Src\Controller\Pedido\PedidoController;

$pedidoController = new PedidoController($conn);
// -------------------------------- Pedidos ------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET['action'] == 'pedido') {
    $pedidoController->create();
}

if (isset($_GET["deletepedido"])) {
    $id = (int)$_GET["deletepedido"];
    $pedidoController->delete($id);
}

$pedidos = $pedidoController->list();

?>

<link rel="stylesheet" href="../style.css">
<h1>Cadastro de Pedidos</h1>

<form method="POST" action="?action=pedido">
    <label for="client">Cliente:</label>
    <select id="client" name="client_id" required>
        <?php foreach ($clientes as $row) { ?>
            <option value="<?php echo $row['id']  ?>"><?php echo $row['name'] ?></option>
        <?php } ?>
    </select>

    <label for="amount">Valor:</label>
    <input type="text" id="amount" name="amount" required>

    <button type="submit">Salvar</button>
</form>

<h2>Lista de Pedidos</h2>

<?php if (!empty($pedidos)) { ?>
    <table>
        <tr>
            <th>ID da compra</th>
            <th>Nome</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($pedidos as $row) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['data_pedido'] ?></td>
                <td><?= $row['valor_final'] ?></td>
                <td>
                    <a class="delete-btn" href="?deletepedido=<?= urlencode($row['id'] ?? '') ?>" onclick="return confirm('Tem certeza que deseja excluir este pedido?');">
                        Excluir
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>Nenhum Pedido cadastrado.</p>
<?php } ?>
