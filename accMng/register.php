<?php
session_start();
$_SESSION['mes'] = '';
        $link = mysqli_connect ("localhost","kirill","q123123q","kirill_forum");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }
        else echo "Successful </br>";
        if ( strlen($_POST['password']) < 6)
	   {
		$_SESSION['mes'] = $_SESSION['mes']." <br> Пароль должен быть длиннее 6 символов. <br>";
			
	   } else 
	if ( strlen($_POST['password']) > 30)
	{
                $_SESSION['mes'] = $_SESSION['mes']."<br> Пароль должен быть не длиннее 30 символов. <br>";			
        }
$data = "SELECT `login` FROM `users` WHERE `login` = {$_POST['login']}";
$res = mysqli_query($link, $data);
if($res)
{
        $rows = mysqli_num_rows($res);
if ($rows != 0)		
        $_SESSION['mes'] = $_SESSION['mes']."<br> Такой логин уже существует. <br>";
unset($rows);
}
if (strlen($_SESSION['mes'])>0)
{
	header("Location: ../accMng/registration.php");
	die (strlen($_SESSION['mes']));
}
$salt = mt_rand(100, 999);
$tm = time();
$_POST['password'] = md5(md5($_POST['password']).$salt);
$regdata = "INSERT INTO `users` (`login`, `pass`,`salt`,`e-mail`,`lvl`) VALUES ( '{$_POST['login'] }','{$_POST['password']}','{$salt}','{$_POST['e-mail']}','0')";
$register = mysqli_query($link, $regdata) or die("Ошибка при регистрации: ".mysqli_error($link)."<br> <a href = '../index.php'> Назад на главную </a>");
if (!$register)
{
	echo "Error :( </br>";
	echo $regdata;
}
else
        header("Location:../index.php");
        $_SESSION['mes'] = "<div style = 'width:500px; background-color: rgba(100,255,100,0.8); color: black; border: 1px solid black; text-align:center;
        margin: 5px 0 5px 0;' >Аккаунт успешно зарегистрирован </div>";
        exit;
?>