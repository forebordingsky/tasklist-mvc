<?php

namespace App\Models;

use App\Core\Database;

class Task extends Database
{
    public int $id;
    public int $user_id;
    public string $description;

    private function __construct(int $id, int $user_id, string $description, int $status)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->description = $description;
        $this->status = (bool)$status;
    }

    public static function create(array $data) : ?Task
    {
        self::run('INSERT INTO tasks (user_id, description) VALUES (:user_id, :description)',$data);
        return self::findById(self::lastInsertId());
    }

    public static function delete(array $data) : bool
    {
        $task = self::findById($data['id']);
        if ($task) {
            self::run('DELETE FROM tasks WHERE id = :id',$data);
            return true;
        }
        return false;
    }

    public static function getUserTasks(int $id) : array
    {
        $tasks = self::getRows('SELECT * FROM tasks WHERE user_id = :user_id',['user_id' => $id]);
        $userTasks = [];
        foreach ($tasks as $task) {
            $userTasks[] = self::newInstance($task);
        }
        return $userTasks;
    }

    public static function changeStatus(array $data) : bool
    {
        $task = self::findById($data['id']);
        if ($task) {
            self::run('UPDATE tasks SET status = :status WHERE id = :id',['id' => $task->id, 'status' => (int)!$task->status]);
            return true;
        }
        return false;
    }

    public static function readyAll(array $data) : bool
    {
        $tasks = self::getUserTasks($data['userId']);
        if (count($tasks)) {
            $stmt = self::prepare('UPDATE tasks SET status = 1 WHERE id = :id');
            foreach ($tasks as $task) {
                $stmt->execute(['id' => $task->id]);
            }
            return true;
        }
        return false;
    }

    public static function deleteAll(array $data) : void
    {
        self::run('DELETE FROM tasks WHERE user_id = :user_id',$data);
    }
    
    public static function findById(int $id) : ?Task
    {
        $task = self::getRow('SELECT * FROM tasks WHERE id = :id',['id' => $id]);
        if (!$task) {
            return null;
        }
        return self::newInstance($task);
    }

    private static function newInstance(array $data) : Task
    {
        return new Task($data['id'], $data['user_id'], $data['description'], $data['status']);
    }
}