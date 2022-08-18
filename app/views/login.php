<form method="POST" action="">
    <input type="text" name="login" placeholder="Login"/>
    <? if ($errors['login']) :?>
        <div><? echo $errors['login'][0] ?></div>    
    <? endif; ?>
    <input type="password" name="password" placeholder="password"/>
    <? if ($errors['password']) :?>
        <div><? echo $errors['password'][0] ?></div>    
    <? endif; ?>
    <button type="submit">Login or Register</button>
</form>