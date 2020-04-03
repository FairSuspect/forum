<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>      
        <meta charset="UTF-8">
        <link rel = stylesheet href='css/viewforum.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    </head>
    <body>
        <div class='quests'>
        <header>
	<h1> ProgPeak Forum</h1>
	<h3> Форум программистов 
	<div style= 'margin-top:-15px' align= right> 
		<form method = GET action = viewforum.php>
			<input type =text name = search  value placeholder='Поиск...'required>
			<button> Найти </button>
		</form>
	</div>
	</h3>
</header>
 <?php 
if(isset($_GET['i'])&&isset($_GET['f']))
{
    if($_GET['i']==1)
        {   
            echo "
            <form class= 'registration' action='../accMng/register.php?f={$_GET['f']}' method='post'>
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
        } 
    elseif($_GET['i']==0 )
    {
        echo "
        <form class= 'registration' action='../accMng/login.php?f={$_GET['f']}' method='post'>
        <h2>Авторизация</h2>
    <p>
        <label>Ваш логин:<br></label>
        <input name='login' type='text' size='20' maxlength='20'>
    </p>
    <p>
        <label>Пароль:<br></label>
        <input name='password' type='password' size='20' maxlength='20'>
    </p>
    <p>
        <button name = log> Вход </button><br>
        Ещё нет аккаунта? <a href=auth.php?i=1> Зарегистрируйтесь! </a>
        
    </p></form>";
    if (!isset($_SESSION['mes']))
        $_SESSION['mes']= '';
    else
        echo "<div style = 'color:red;'> {$_SESSION['mes']}</div>";
    }
    else {
        header("Location: index.php");
        exit;
    }

}
else {
    header("Location: index.php");
    exit;
}
?>
</div></body></html>
