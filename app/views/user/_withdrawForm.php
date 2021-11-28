<?php
/**
 * Форма списания
 */
?>
<div>
    <form action="/user/profile" method="post">
        <input type="text" name="balance" value="" placeholder="Количество">
        <input type="submit" value="Вывести">
        <?if(isset($errors['balance'])):?><div style="color:red"><?=$errors['balance']?></div><?endif?>
    </form>
</div>
