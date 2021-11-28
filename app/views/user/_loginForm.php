<div>
    <form action="/user/login" method="post">
        <div class="form-group">
            <input type="email" name="email" value="" placeholder="Email">
            <?if(isset($errors['email'])):?><div style="color:red"><?=$errors['email']?></div><?endif?>
        </div>
        <div class="form-group">
            <input type="password" name="password" value="" placeholder="Пароль">
            <?if(isset($errors['password'])):?><div style="color:red"><?=$errors['password']?></div><?endif?>
        </div>
        <input type="submit" value="Войти">
    </form>
</div>