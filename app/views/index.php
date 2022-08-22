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

<a class="button" href="/logout">Logout</a>
<hr>
<? if (isset($message)) :?>
        <div><? echo $message ?></div>    
    <? endif; ?>

<form method="POST" action="" class="task-form">
    <input type="text" name="description"/>
    <? if (isset($errors['description'])) :?>
        <div><? echo $errors['description'][0] ?></div>    
    <? endif; ?>
    <button type="submit" class="button">Add task</button> 
</form>
<? if (!empty($user->tasks)) : ?>
    <div class="row mb-10">
        <form action="/ready-all" method="POST">
            <button class="button" type="submit">Ready All</button>
        </form>
        <form action="/delete-all" method="POST">
            <button class="button" type="submit">Delete All</button>
        </form>
    </div>
<? endif; ?>

<? if (empty($user->tasks)) : ?>
    <p>No tasks...</p>
<? else : ?>
    <? foreach ($user->tasks as $task) : ?>
        <div class="row mb-10">
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