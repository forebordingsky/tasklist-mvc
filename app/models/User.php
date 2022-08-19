<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    public int $id;
    public string $login;
    protected string $password;

    private function __construct(int $id, string $login, string $password)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
    }

    public static function findById(int $id) : User|false
    {
        $user = self::getRow('SELECT * FROM users WHERE id = :id',['id' => $id]);
        if (!$user) {
            return false;
        }
        return self::newInstance($user);
    }

    public static function findByLogin(string $login) : User|false
    {
        $user = self::getRow('SELECT * FROM users WHERE login = :login',['login' => $login]);
        if (!$user) {
            return false;
        }
        return self::newInstance($user);
    }

    public function authorize(string $password) : bool
    {
        if (password_verify($password, $this->password)) {
            return true;
        }
        return false;
    }

    public static function create(array $data) : User|false
    {
        $data = [
            'login' => $data['login'],
            'password' => password_hash($data['password'],PASSWORD_BCRYPT)
        ];
        if (self::run('INSERT INTO users (login, password) VALUES (:login, :password)',$data)){
            return self::findById(self::lastInsertId());
        }
        return false;
    }

    private static function newInstance(array $data) : User
    {
        return new User($data['id'], $data['login'], $data['password']);
    }
}