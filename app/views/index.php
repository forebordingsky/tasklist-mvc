<? echo $title ?><br/>

<a href="/logout">Logout</a>

<? if (isset($message)) :?>
        <div><? echo $message ?></div>    
    <? endif; ?>

<form method="POST" action="">
    <input type="text" name="description"/>
    <? if (isset($errors['description'])) :?>
        <div><? echo $errors['description'][0] ?></div>    
    <? endif; ?>
    <input type="hidden" name="user_id" value="<? echo $user->id ?>"/>
    <button type="submit">Add task</button> 
</form>

<? if (empty($userTasks)) : ?>
    <p>No tasks...</p>
<? endif; ?>