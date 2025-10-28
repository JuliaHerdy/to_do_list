<?php
$conn = pg_connect("host=192.168.241.61 port=5432 dbname=postgres user=root password=123");

if (! $conn) {
    die("Erro ao se conectar no banco de dados");
}

if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];
    $query = "delete from tasks where id = $1";
    $result = pg_query_params($conn, $query, [$id]);

    if ($result) {
        echo "Task excluída com sucesso!";
    } else {
        echo "Erro ao excluir task: " . pg_last_error($conn);
    }
}

if (isset($_GET["changestatus"])) {
    $id = (int)$_GET["changestatus"];
    $query = "update tasks set status = 1 where id = $1";
    $result = pg_query_params($conn, $query, [$id]);
}

$tasklist = pg_query($conn, "select * from tasks order by id asc");
$tasks = pg_fetch_all($tasklist);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>To do list</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>TO DO LIST</h1>
    <form method="POST" action="?action=tasks">
        <label for="client">Atividade:</label>
        <input type="text" id="amount" name="amount" required>

        <label for="amount">Descrição:</label>
        <input type="text" id="amount" name="amount" required>

        <label for="amount">Prazo:</label>
        <input type="date" id="date" name="amount" required>

        <button type="submit">Salvar</button>
    </form>


    <?php if (!empty($tasks)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Descrição</th>
                <th>Data de início</th>
                <th>Prazo</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($tasks as $row) {
                     if ($row["status"] == 1) {?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td class="overline"><?= $row['task_title'] ?></td>
                    <td class="overline"><?= $row['task_description'] ?></td>
                    <td><?= $row['start_date'] ?></td>
                    <td><?= $row['deadline'] ?></td>
                    <td>
                        <a class="delete-btn" href="?delete=<?= urlencode($row['id'] ?? '') ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                            Excluir
                        </a>
                        <br>
                        <br>
                        <a class="complete-btn" href="?changestatus=<?= urlencode($row['id'] ?? '') ?>">
                            Feito
                        </a>
                    </td>
                </tr>
            <?php } ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['task_title'] ?></td>
                    <td><?= $row['task_description'] ?></td>
                    <td><?= $row['start_date'] ?></td>
                    <td><?= $row['deadline'] ?></td>
                    <td>
                        <a class="delete-btn" href="?delete=<?= urlencode($row['id'] ?? '') ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                            Excluir
                        </a>
                        <br>
                        <br>
                        <a class="complete-btn" href="?changestatus=<?= urlencode($row['id'] ?? '') ?>">
                            Feito
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>Nenhum Pedido cadastrado.</p>
    <?php } ?>

</body>
