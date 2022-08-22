<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function loginOrRegisterPage()
    {
        if (Application::isGuest()) {
            return $this->render('login','main');
        }
        return $this->back();
    }

    public function loginOrRegisterHandler(Request $request)
    {
        $rules = [
            'login' => ['required', 'alpha', 'min5'],
            'password' => ['required', 'min3']
        ];
        if ($errors = $request->validate($rules)){
            Application::$app->session->set('errors', $errors);
            return $this->redirect('/login');
        }
        $data = $request->getBody();
        $user = User::findByLogin($data['login']);
        if ($user === null) {
            $user = User::create($data);
        }
        if (User::checkPassword($data['password'], $user->password)) {
            Application::$app->login($user);
            return $this->redirect('/');
        }
        Application::$app->session->set('message', 'Wrong login or password.');
        return $this->redirect('/login');
    }

    public function logoutHandler()
    {
        if (Application::isGuest()) {
            return $this->redirect('/login');
        }
        Application::$app->logout();
        return $this->redirect('/login');
    }
}