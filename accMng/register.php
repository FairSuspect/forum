<?php
session_start();
$_SESSION['mes'] = '';
        $link = mysqli_connect ("localhost","root","","users");
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
$regdata = "INSERT INTO `users` (`login`, `pass`,`salt`,`e-mail`) VALUES ( '{$_POST['login'] }','{$_POST['password']}','{$salt}','{$_POST['e-mail']}')";
$register = mysqli_query($link, $regdata);
if (!$register)
{
	echo "Error :( </br>";
	echo $regdata;
}
else
	{
        echo "Регистрирую..<br>";
        $sql = "SELECT `id` FROM `users` WHERE `login`='{$_POST['login']}'";
        $res = mysqli_query($link,$sql) or die("Ошибка при загрузке логина: ".mysqli_error($link));
        if($res)
        {       

                $id = mysqli_fetch_row($res);
                $key = md5(md5($_POST['login']).$salt);
                $sql = "INSERT INTO `waiting` (`id`,`login`,`e-mail`,`e-key`,`salt`) VALUES ( '{$id[0]}','{$_POST['login']}','{$_POST['e-mail']}','{$key}','{$salt}')";
                $add = mysqli_query($link,$sql);
                echo "Зарегистрировал, пытаемся сделать письмо..<br>";
                if($add)
                {
                        echo "<fieldset><legend> Имитация электронного письма </legend>";
                        $message = "Здравствуйте, ваша почта была введена при регистрации на форуме ###.
                        Для подтверждения электронной почты, пройдите по этой <a href='action.php?u={$id[0]}&key={$key}'>ссылке</a>.
                        Если вы нигде не регистрировались, то просто проигнорируйте это письмо.</filedset>";
                        $subject = "Подтвердите регистрацию на ###";
                        echo $subject;
                        echo "<br>";
                        echo $message;
                        //mail();
                }
                else die("Ошибка при 'создании сообщения': ".mysqli_error($link));
		
        }
               
}



?>
<a class="nav" href="../old.php"> Old main page </a>