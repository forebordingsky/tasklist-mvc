<?php 
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
    }
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<form method="POST" action="" class="login-form">
    
    <input type="text" name="login" placeholder="Login"/>
    <? if (isset($errors['login'])) :?>
        <div><? echo $errors['login'][0] ?></div>    
    <? endif; ?>
    <input type="password" name="password" placeholder="password"/>
    <? if (isset($errors['password'])) :?>
        <div><? echo $errors['password'][0] ?></div>    
    <? endif; ?>
    <button type="submit" class="button">Login or Register</button>
    <? if (isset($message)) :?>
        <div><? echo $message ?></div>    
    <? endif; ?>
</form>