<?php 

namespace App\Core;

class View
{
    /**
     * Создает представление из шаблона и представления, создает переменные в представлении из $data
     *
     * @param string $layout Имя файла шаблона в папке app/views/layouts
     * @param string $view Имя файла представления в папке app/views/
     * @param array $data Массив данных
     * @return void
     */
    public function render(string $layout, string $view, array $data = [])
    {
        $layoutContent = $this->layoutContent($layout);
        $viewContent = $this->renderView($view, $data);
        return str_replace('{{ slot }}', $viewContent, $layoutContent);
    }

    /**
     * Возвращает view и создает переменные из массива $data
     *
     * @param string $view Имя файла представления в папке app/views/
     * @param array $data Массив данных
     * @return string
     */
    public function renderView(string $view, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/app/views/$view.php";
        return ob_get_clean();
    }

    /**
     * Возвращает содержимое шаблона
     *
     * @param string $layout Имя файла шаблона в папке app/views/layouts
     * @return string
     */
    protected function layoutContent(string $layout)
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/app/views/layouts/$layout.php";
        return ob_get_clean();
    }
    
}