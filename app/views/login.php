<form method="POST" action="">
    <input type="text" name="login" placeholder="Login"/>
    <? if (isset($errors['login'])) :?>
        <div><? echo $errors['login'][0] ?></div>    
    <? endif; ?>
    <input type="password" name="password" placeholder="password"/>
    <? if (isset($errors['password'])) :?>
        <div><? echo $errors['password'][0] ?></div>    
    <? endif; ?>
    <button type="submit">Login or Register</button>
    <? if (isset($message)) :?>
        <div><? echo $message ?></div>    
    <? endif; ?>
</form>