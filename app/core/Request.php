<?php

namespace App\Core;

class Request
{
    /**
     * Получаем путь запроса из url и возвращаем только путь, без GET параметров
     *
     * @return string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    /**
     * Получаем вид запроса
     *
     * @return string
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Проверка на GET запрос
     *
     * @return boolean
     */
    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    /**
     * Проверка на POST запрос
     *
     * @return boolean
     */
    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Принимаем все параметры из GET или POST запроса и возвращем массив данных
     *
     * @return array
     */
    public function getBody()
    {
        $body = [];

        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    /**
     * Валидация запроса, возвращает массив с ошибками валидации
     *
     * @param array $rules Ассоциативный массив с правилами для валидации
     * @return array Возвращает массив с ошибками валидации
     */
    public function validate(array $rules)
    {
        $data = $this->getBody();
        $errors = [];
        foreach ($rules as $attribute => $ruleSet) {
            foreach ($ruleSet as $rule) {
                if ($rule === 'required' && isset($data[$attribute]) && empty($data[$attribute])) {
                    $errors[$attribute][] = ucfirst($attribute) . ' field is required';
                }
                if ($rule === 'alpha' && !ctype_alpha($data[$attribute])) {
                    $errors[$attribute][] = ucfirst($attribute) . ' field must contain only alphabetic characters.';
                }
                if ($rule === 'alphaNumeric' && !ctype_alnum($data[$attribute])) {
                    $errors[$attribute][] = ucfirst($attribute) . ' field must contain only characters and numbers.';
                }
                if (strpos($rule, 'min') !== false) {
                    $minRule = (int)explode('min',$rule)[1];
                    if (strlen($data[$attribute]) < $minRule) {
                        $errors[$attribute][] = ucfirst($attribute) . ' field must be atleast ' . $minRule . ' characters.';
                    }
                }
                if (strpos($rule, 'max') !== false) {
                    $maxRule = (int)explode('max',$rule)[1];
                    if (strlen($data[$attribute]) > $maxRule) {
                        $errors[$attribute][] = ucfirst($attribute) . ' field should not be more than ' . $maxRule . ' characters.';
                    }
                }
            }
        }
        return $errors;
    }
}