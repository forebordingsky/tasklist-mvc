<?php

namespace App\Models;

use App\Core\Application;
use App\Core\Database;

class Task extends Database
{
    public int $id;
    public int $user_id;
    public string $description;

    private function __construct(int $id, int $user_id, string $description)
    {
        $this->id = $id;
        $this->login = $user_id;
        $this->password = $description;
    }

    public static function create(array $data)
    {
        if (self::run('INSERT INTO tasks (user_id, description, status) VALUES (:user_id, :description, status = 0)',$data)){
            return self::findById(self::lastInsertId());
        }
        return false;
    }

    public static function getUserTasks()
    {
        $tasks = self::getRows('SELECT * FROM tasks WHERE user_id = :user_id',['user_id' => Application::$app->user->id]);
        if (count($tasks)) {
            $userTasks = [];
            foreach ($tasks as $task) {
                $userTasks[] = self::newInstance($task);
            }
            return $userTasks;
        }
        return false;
    }
    
    public static function findById(int $id)
    {

    }

    private static function newInstance(array $data) : Task
    {
        return new Task($data['id'], $data['user_id'], $data['description']);
    }
}