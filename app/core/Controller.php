<?php 

namespace App\Core;

class Controller
{
    /**
     * Создает представление из шаблона, представления и данных
     *
     * @param string $layout Имя файла шаблона в папке app/views/layouts
     * @param string $view Имя файла представления в папке app/views/
     * @param array $data Ассоциативный массив
     * @return string
     */
    public function render(string $view, string $layout, array $data = [])
    {
        return (new View)->render($layout, $view, $data);
    }

    /**
     * Создает представление из представления и данных
     *
     * @param string $view Имя файла представления в папке app/views/
     * @param array $data Ассоциативный массив
     * @return void
     */
    public function renderView(string $view, array $data = [])
    {
        return (new View)->renderView($view, $data);
    }

    public function redirect(string $location)
    {
        header("location: $location");
        exit;
    }

    public function back()
    {
        header('location: '. ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
}