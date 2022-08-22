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

    public static function create(array $data) : Task|false
    {
        if (self::run('INSERT INTO tasks (user_id, description, status) VALUES (:user_id, :description, 0)',$data)){
            return self::findById(self::lastInsertId());
        }
        return false;
    }

    public static function delete(array $data)
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

    public static function readyAll(array $data)
    {
        $tasks = self::getUserTasks($data['userId']);
        if (count($tasks)) {
            foreach ($tasks as $task) {
                self::run('UPDATE tasks SET status = 1 WHERE id = :id', ['id' => $task->id]);
            }
            return true;
        }
        return false;
    }
    
    public static function findById(int $id) : Task|false
    {
        $task = self::getRow('SELECT * FROM tasks WHERE id = :id',['id' => $id]);
        if (!$task) {
            return false;
        }
        return self::newInstance($task);
    }

    private static function newInstance(array $data) : Task
    {
        return new Task($data['id'], $data['user_id'], $data['description'], $data['status']);
    }
}