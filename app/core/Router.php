<?php

namespace App\Core;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Добавить в массив маршрутов $routes GET запрос
     *
     * @param string $path
     * @param callable $callback
     * @return void
     */
    public function get(string $path, callable $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Добавить в массив маршрутов $routes POST запрос
     *
     * @param string $path
     * @param callable $callback
     * @return void
     */
    public function post(string $path, callable $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Ищем указанный маршрут и выполняем метод, указанный вторым параметром
     *
     * @return void
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return (new View)->renderView('_404');
        }
        if(is_array($callback)) {
            $callback[0] = new $callback[0]();
        }
        return call_user_func($callback, $this->request);
    }


}