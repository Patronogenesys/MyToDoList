<?php

namespace App\Services;

use App\Kernel\Auth\Auth;
use App\Kernel\Auth\AuthInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Database\DataModels\TaskModel;

class TaskService
{
    public function __construct(private DatabaseInterface $db)
    {
    }

    /**
     * @return TaskModel[]
     */
    public function getAllTasksByUserId(?int $id, $default = []): array
    {
        if ($id === null) {
            return $default;
        }

        $tasks = $this->db->get('tasks', ['fk_id_user' => $id]);

        return array_map(fn($task) => TaskModel::createFromArray($task), $tasks);
    }

    public function updateAllTasksByUserId(?int $id, array $tasksFromJson): bool
    {
        if ($id === null) {
            return false;
        }

        $this->db->delete('tasks', ['fk_id_user' => $id]);

        foreach ($tasksFromJson as $task) {
            $task['userId'] = $id;
            $task = TaskModel::createFromJsonDecoded($task);
            if (!$this->db->insert('tasks', $task->toArrayNoId())) {
                return false;
            }
        }
        return true;
    }
}
