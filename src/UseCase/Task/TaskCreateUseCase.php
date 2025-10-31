<?php

namespace Src\UseCase\Task;

use src\database\database;

class TaskCreateUseCase {

    public function __construct(protected database $database) {}

    public function execute(string $task_title, string $task_description, int $deadline): bool {
        $query = "insert into tasks (task_title, task_description, deadline) values ($1, $2, $3)";
        $result = pg_query_params($this->database->getConnection(), $query, [$task_title, $task_description, $deadline]);

        if ($result) {
            return true;
        }
        return false;
    }
}
