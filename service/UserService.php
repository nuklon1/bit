<?php

namespace service;

use app\models\User;

class UserService
{
    public static function get()
    {
        if (!isset($_SESSION['user']['id'])) {
            return null;
        }

        $userId = $_SESSION['user']['id'];
        $user = (new User())->findById($userId);

        if (!$user instanceof User) {
            self::setSession($user);
        }

        return $user;
    }

    public static function setSession(User $user)
    {
        $_SESSION['user']['id'] = $user->id;
    }

    public static function logout()
    {
        unset($_SESSION['user']);
        header('Location: /');
    }

}