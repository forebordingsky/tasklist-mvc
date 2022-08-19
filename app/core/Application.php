<?php

namespace App\Core;

use App\Models\User;

class Application
{

    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;

    public ?User $user;

    public static Application $app;

    public static string $ROOT_DIR;

    public function __construct(string $root_path)
    {
        $this->user = null;
        self::$app = $this;
        self::$ROOT_DIR = $root_path;
        $this->request = new Request();
        $this->response = new Response();
        $this->db = new Database();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $userId = self::$app->session->get('userId');
        if ($userId) {
            $this->user = User::findById($userId);
        }

    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function login(User $user)
    {
        $this->userId = $user->id;
        self::$app->session->set('userId',$this->userId);
        return true;
    }

    public function logout()
    {
        $this->userId = null;
        self::$app->session->clear();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}