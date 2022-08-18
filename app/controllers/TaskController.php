<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class TaskController extends Controller
{
    public function index()
    {
        return $this->renderView('index',['title' => 'Main page']);
    }

    public function create(Request $request)
    {
        $body = $request->getBody();    
    }
}