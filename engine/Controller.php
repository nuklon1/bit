<?php

namespace engine;

use app\models\User;
use service\UserService;

class Controller
{
    /**
     * @var string $tpl Шаблон по умолчанию
     */
    public string $tpl = '_default';

    /**
     * @var array $request Получаемые данные
     */
    public array $request;

    /**
     * @var User|null Текущий пользователь
     */
    public ?User $user = null;

    /**
     * @var array Ошибки для вывода на экран (простой вариант, без сохранения в сессию/базу)
     */
    public array $errors = [];


    public function __construct()
    {
        $this->request = $this->getParams();
        $this->user ??= UserService::get();
    }

    public function render($view, $data = [])
    {
        (new View($this->tpl, $view, $data))->render();
    }

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Получает данные из GET|POST
     * @return array
     */
    public function getParams(): array
    {
        $request = [];
        $inputType = 0;
        if ($this->isGet()) {
            $request = $_GET;
            $inputType = INPUT_GET;
        } elseif ($this->isPost()) {
            $request = $_POST;
            $inputType = INPUT_POST;
        }

        if (!empty($request)) {
            foreach ($request as $k => $item) {
                $request[$k] = filter_input($inputType, $k, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $request;
    }

    public function userExist(): bool
    {
        return $this->user instanceof User;
    }
}