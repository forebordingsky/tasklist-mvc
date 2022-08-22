<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Task;
use Exception;

class TaskController extends Controller
{
    public function index()
    {
        if (Application::isGuest()) {
            return $this->redirect('/login');
        }
        return $this->render('index','main',[
            'title' => 'Main page',
            'user' => Application::$app->user
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
        return $this->redirect('/');
        //return $this->render('index','main', ['message' => 'Success.']);  
    }

    public function delete(Request $request)
    {
        $rules = [
            'id' => ['required']
        ];
        if ($errors = $request->validate($rules)){
            return $this->render('index', 'main', ['errors' => $errors]);
        }
        $data = $request->getBody();
        $result = Task::delete($data);
        if (!$result) {
            throw new Exception('Not found');
        }
        return $this->redirect('/');
    }

    public function changeStatus(Request $request)
    {
        $rules = [
            'id' => ['required']
        ];
        if ($errors = $request->validate($rules)){
            return $this->render('index', 'main', ['errors' => $errors]);
        }
        $data = $request->getBody();
        $result = Task::changeStatus($data);
        if (!$result) {
            throw new Exception('Not found');
        }
        return $this->redirect('/');
    }

    public function readyAll(Request $request)
    {
        
    }
}