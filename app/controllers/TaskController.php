<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        if (Application::isGuest()) {
            return $this->redirect('/login');
        }
        $userTasks = Task::getUserTasks();
        return $this->renderView('index',[
            'title' => 'Main page',
            'user' => Application::$app->user,
            'userTasks' => $userTasks
        ]);
        
    }

    public function create(Request $request)
    {
        $rules = [
            'description' => ['required', 'min3']
        ];
        if ($errors = $request->validate($rules)){
            return $this->render('index', 'main', ['errors' => $errors]);
        }
        $data = $request->getBody();
        Task::create($data);
        return $this->render('index','main', ['message' => 'Success.']);  
    }
}