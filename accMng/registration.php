<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>      
        <meta charset="UTF-8">
        <link rel = stylesheet href='../css/viewforum.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    </head>
    <body>
        <div class='quests'>
 <?php 

    echo "
    <form class= 'registration' action='../accMng/register.php' method='post'>
    <h2>Регистрация</h2>
<p>
    <label>Ваш логин:<br></label>
    <input name='login' type='text' size='20' maxlength='20'>
</p>
<p>
    <label>Ваш e-mail:<br></label>
    <input name='e-mail' type='text' size='20' maxlength='40'>
</p>
<p>
    <label>Ваш пароль:<br></label>
    <input name='password' type='password' size='20' maxlength='20'>
</p>
<p>
    <input type='submit' name='submit' value='Зарегистрироваться'>
</p></form>";
?>
<?php
if (!isset($_SESSION['mes']))
	$_SESSION['mes']= '';
else
	echo "<div style = 'color:red;'> {$_SESSION['mes']}</div>";
?>
</div>
    </body>
    </html>
