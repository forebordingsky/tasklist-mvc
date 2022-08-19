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
            return $this->render('login', 'main', ['errors' => $errors]);
        }
        $data = $request->getBody();
        $user = User::findByLogin($data['login']);
        if ($user == false) {
            User::create($data);
        }
        if ($user->authorize($data['password'])) {
            Application::$app->login($user);
            return $this->redirect('/');
        }
        return $this->render('login', 'main', ['message' => 'Wrong login or password.']);
        
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