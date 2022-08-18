<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class AuthController extends Controller
{
    public function loginOrRegisterPage()
    {
        return $this->render('login','main');
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
        return 'Handle';
    }
}