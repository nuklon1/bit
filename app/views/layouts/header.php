<?php
/**
 * @var \app\models\User $user
 */
?>
<div>
    <ul>
        <li><a href="/">Главная</a></li>
        <?if($user):?>
        <li><a href="/user/profile">Профиль</a></li>
        <li><a href="/user/logout">Выход</a></li>
        <?else:?>
            <li><a href="/user/login">Вход</a></li>
        <?endif?>
    </ul>
</div>
