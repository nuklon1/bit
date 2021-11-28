<?php
/**
 * Профиль пользователя
 *
 * @var string $h1
 * @var \app\models\User $user
 */
?>
<div>
    <h1><?=$h1?>::<span><?=$user->name?></span></h1>
    <ul>
        <li>Баланс: <span><?=$user->balance?></span> руб</li>
        <li>Номер карты: <span><?=$user->cardNumber?></span></li>
    </ul>
    <? include '_withdrawForm.php' ?>
</div>
