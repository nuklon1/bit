<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\WithdrawForm;
use engine\Controller;
use engine\View;
use service\UserService;

class MainController extends Controller
{
    public function index()
    {
        View::setMeta('Bit', 'Bit - тестовое задание');

        $this->render('main', [
            'h1' => 'Главная страница',
            'user' => $this->user,
        ]);
    }

    public function login()
    {
        if ($this->userExist()) {
            UserService::logout();
        }

        View::setMeta('Авторизация', 'Bit - авторизация пользователя');

        // Авторизация
        if ($this->isPost()) {
            $loginFormModel = new LoginForm();
            $loginFormModel->loadParams($this->getParams());
            if ($loginFormModel->validate() && $loginFormModel->login()) {
                header('Location: /user/profile');
            }

            $this->errors = $loginFormModel->errors;
        }

        $this->render('user/login', [
            'h1' => 'Авторизация',
            'user' => $this->user,
            'errors' => $this->errors,
        ]);
    }

    public function logout()
    {
        UserService::logout();
    }

    public function profile()
    {
        if (!$this->userExist()) {
            header('Location: /user/login');
        }

        if ($this->isPost()) {
            session_write_close();
            $withdrawFormModel = new WithdrawForm();
            $withdrawFormModel->loadParams($this->getParams());
            if ($withdrawFormModel->withdraw($this->user)) {
                header('Location: /user/profile');
            }

            $this->errors = $withdrawFormModel->errors;
        }

        View::setMeta('Профиль пользователя ' . $this->user->name, 'Bit - профиль пользователя');

        $this->render('user/profile', [
            'h1' => 'Профиль',
            'user' => $this->user,
            'errors' => $this->errors,
        ]);
    }

    public function withdraw()
    {
        session_write_close();
        $withdrawFormModel = new WithdrawForm();
        $withdrawFormModel->loadParams($this->getParams());
        if ($withdrawFormModel->withdraw($this->user)) {
            header('Location: /user/profile');
        }
    }
}