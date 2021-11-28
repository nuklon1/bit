<?php

namespace app\models;

use engine\Model;
use service\UserService;

class LoginForm extends Model
{
    public string $email;
    public string $password;

    public function rules(): array
    {
        return [
            ['email, password', ['required']]
        ];
    }

    public function login(): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `user` WHERE `email` = :email');
        $stmt->execute(['email' => $this->email]);
        $user = $stmt->fetchObject(User::class);

        if (!$user) {
            $this->errors['email'] = 'Пользователя с таким email в базе нет';
            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            $this->errors['password'] = 'Неверный пароль';
            return false;
        }

        UserService::setSession($user);

        return true;
    }
}