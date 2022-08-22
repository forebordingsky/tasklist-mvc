<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    public int $id;
    public string $login;
    public string $password;

    public array $tasks;

    private function __construct(int $id, string $login, string $password)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->tasks = Task::getUserTasks($this->id);
    }

    public static function findById(int $id) : ?User
    {
        $user = self::getRow('SELECT * FROM users WHERE id = :id',['id' => $id]);
        return self::newInstance($user);
    }

    public static function findByLogin(string $login) : ?User
    {
        $user = self::getRow('SELECT * FROM users WHERE login = :login',['login' => $login]);
        if (!$user) {
            return null;
        }
        return self::newInstance($user);
    }

    public static function checkPassword(string $password, string $hash) : bool
    {
        if (password_verify($password, $hash)) {
            return true;
        }
        return false;
    }

    public static function create(array $data) : ?User
    {
        $data = [
            'login' => $data['login'],
            'password' => password_hash($data['password'],PASSWORD_BCRYPT)
        ];
        if (self::run('INSERT INTO users (login, password) VALUES (:login, :password)',$data)){
            return self::findById(self::lastInsertId());
        }
        return null;
    }

    private static function newInstance(array $data) : User
    {
        return new User($data['id'], $data['login'], $data['password']);
    }
}