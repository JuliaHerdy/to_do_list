<?php

require_once __DIR__ . '/vendor/autoload.php';

use Src\Database\Database;

$conn = new Database("192.168.241.61", "root", "123", "postgres", "5432");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_title = trim($_POST["task_title"]);
    $task_description = trim($_POST["task_description"]);
    $deadline = trim($_POST["deadline"]);
    if ($task_title !== "") {
        $query = "insert into tasks (task_title, task_description, deadline) values ($1, $2, $3)";
        $result = pg_query_params($conn->getConnection(), $query, [$task_title, $task_description, $deadline]);

        if ($result) {
            echo "Task cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar a Task: " . pg_last_error($conn->getConnection());
        }
    } else {
        echo "Task é Obrigatória!";
    }
}

if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];
    $query = "delete from tasks where id = $1";
    $result = pg_query_params($conn->getConnection(), $query, [$id]);

    if ($result) {
        echo "Task excluída com sucesso!";
    } else {
        echo "Erro ao excluir Task: " . pg_last_error($conn->getConnection());
    }
}

if (isset($_GET["changestatus"])) {
    $id = (int)$_GET["changestatus"];
    $query = "update tasks set status = 1 where id = $1";
    $result = pg_query_params($conn->getConnection(), $query, [$id]);
}

$tasklist = pg_query($conn->getConnection(), "select * from tasks order by id asc");
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
    <div class="inputs">
        <h1>TO DO LIST</h1>
        <form method="POST" action="?action=tasks">
            <label for="task_title">Task:</label>
            <input type="text" id="task_title" name="task_title" required>

            <label for="task_description">Descrição:</label>
            <input type="text" id="task_description" name="task_description" required>

            <label for="deadline">Prazo:</label>
            <input type="date" id="deadline" name="deadline" required>

            <button type="submit">Salvar</button>
        </form>
    </div>


    <div class="taskstable">
        <?php if (!empty($tasks)) { ?>
            <table>
                <tr>
                    <th>Task</th>
                    <th>Data de início</th>
                    <th>Prazo</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($tasks as $row) {
                    if ($row["status"] == 1) {?>
                        <tr>
                            <td class="overline">
                                <h2 class="title"><?= $row['task_title'] ?></h2>
                                <p class="description"><?= $row['task_description'] ?></p>
                            </td>
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
                    <?php } else {?>
                    <tr>
                        <td>
                            <h2 class="title"><?= $row['task_title'] ?></h2>
                            <p class="description"><?= $row['task_description'] ?></p>
                        </td>
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
                <?php } } ?>
            </table>
        <?php } else { ?>
            <p>Nenhum Pedido cadastrado.</p>
        <?php } ?>
    </div>


</body>
