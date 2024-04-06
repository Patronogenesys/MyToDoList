<?php

namespace App\Kernel\Database\DataModels;

class TaskModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $text,
        public readonly bool $isDone,
        public readonly string $column,
        public readonly int $userId,
    ) {
    }

    /** 
     * Keys match the fiels of the database
     */
    public static function createFromArray(array $data): ?self
    {
        if ($data["id_task"] === null || $data["text"] === null || $data["is_done"] === null || $data["task_column"] === null || $data["fk_id_user"] == null) {
            return null;
        }
        return new self(
            id: (int) $data["id_task"],
            text: (string) $data["text"],
            isDone: (bool) $data["is_done"],
            column: (string) $data["task_column"],
            userId: (string) $data["fk_id_user"],
        );
    }


    /** 
     * Keys match the properties of the class
     */
    public static function createFromJsonDecoded(array $data): ?self
    {
        if ($data["text"] === null || $data["isDone"] === null || $data["column"] === null || $data["userId"] == null) {
            return null;
        }
        if (!isset($data["id"])) {
            $data["id"] = null;
        }
        return new self(
            id: (int) $data["id"] || null,
            text: (string) $data["text"],
            isDone: (bool) $data["isDone"],
            column: (string) $data["column"],
            userId: (string) $data["userId"],
        );
    }

    /** 
     * Keys match the fiels of the database
     */
    public function toArray(): array
    {
        return [
            "id_task" => $this->id,
            "text" => $this->text,
            "is_done" => $this->isDone,
            "task_column" => $this->column,
            "fk_id_user" => $this->userId,
        ];
    }
    public function toArrayNoId(): array
    {
        return [
            "text" => $this->text,
            "is_done" => $this->isDone,
            "task_column" => $this->column,
            "fk_id_user" => $this->userId,
        ];
    }
}
