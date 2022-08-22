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
            Application::$app->session->set('errors', $errors);
            return $this->redirect('/');
        }
        $data = [
            'user_id' => Application::$app->user->id,
            'description' => $request->getBody()['description']
        ];
        Task::create($data);
        Application::$app->session->set('message', 'Success');
        return $this->redirect('/'); 
    }

    public function delete(Request $request)
    {
        $rules = [
            'id' => ['required']
        ];
        if ($errors = $request->validate($rules)){
            Application::$app->session->set('errors', $errors);
            return $this->redirect('/');
        }
        $data = $request->getBody();
        $result = Task::delete($data);
        if (!$result) {
            Application::$app->session->set('message', 'Not found');
            return $this->redirect('/');
        }
        Application::$app->session->set('message', 'Success');
        return $this->redirect('/');
    }

    public function changeStatus(Request $request)
    {
        $rules = [
            'id' => ['required']
        ];
        if ($errors = $request->validate($rules)){
            Application::$app->session->set('errors', $errors);
            return $this->redirect('/');
        }
        $data = $request->getBody();
        $result = Task::changeStatus($data);
        if (!$result) {
            Application::$app->session->set('message', 'Not found');
            return $this->redirect('/');
        }
        Application::$app->session->set('message', 'Success');
        return $this->redirect('/');
    }

    public function readyAll()
    {
        if (Application::$app->user) {
            Task::readyAll(['userId' => Application::$app->user->id]);
            Application::$app->session->set('message', 'Success');
            return $this->redirect('/');
        }
        Application::$app->session->set('message', 'User not found');
        return $this->redirect('/');
    }

    public function deleteAll()
    {
        if (Application::$app->user) {
            Task::deleteAll(['user_id' => Application::$app->user->id]);    
            Application::$app->session->set('message', 'Success');
            return $this->redirect('/');
        }
        Application::$app->session->set('message', 'User not found');
        return $this->redirect('/');
    }
}