<? echo $title ?><br/>

<a href="/logout">Logout</a>

<pre>
<? var_dump($user->tasks) ?>
</pre>

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

<? if (empty($user->tasks)) : ?>
    <p>No tasks...</p>
<? else : ?>
    <? foreach ($user->tasks as $task) : ?>
        <div style="display:flex; gap: 10px;">
                <div style="min-width: 200px;">
                    <p><? echo $task->description  ?></p>
                    <div style="display:flex; gap: 6px;">
                        <form action="/change-status" method="POST">
                            <input type="hidden" name="id" value="<?php echo $task->id; ?>"/>
                            <input type="submit" class="button" value="<?php echo($task->status == true) ? 'Unready' : 'Ready' ?>"/>
                        </form>
                        <form action="/delete" method="POST">
                            <input type="hidden" name="id" value="<?php echo $task->id; ?>"/>
                            <input type="submit" class="button" value="Delete"/>
                        </form>
                    </div>
                </div>
                <div class="circle" style="border: 2px solid <?php echo ($task->status == true) ? 'green' : 'red' ?>">
                </div>
            </div>
    <? endforeach; ?>
<? endif; ?>