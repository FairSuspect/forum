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
	   else echo "Successful connect</br>";
	   if ( strlen($_POST['password']) < 6)
	   {
			$_SESSION['mes'] = $_SESSION['mes']." <br> Пароль должен быть длиннее 6 символов. <br>";
			
	   } else 
	   if ( strlen($_POST['password']) > 30)
	   {
			$_SESSION['mes'] = $_SESSION['mes']."<br> Пароль должен быть не длиннее 30 символов. <br>";
			
	   }

$data = "SELECT `login` FROM `users`";
$res = mysqli_query($link, $data);
$rows = mysqli_num_rows($res);
for ($i = 0; $i < $rows; $i++)
{
	$row = mysqli_fetch_row($res);
	if ($row[0] == $_POST['login'])
	{		
		$_SESSION['mes'] = $_SESSION['mes']."<br> Такой логин уже существует. <br>";
		break;
	}
	
}
if (strlen($_SESSION['mes'])>0)
	{
		header("Location: ../accMng/registration.php");
		die (strlen($_SESSION['mes']));
	}
$salt = mt_rand(100, 999);
$tm = time();
$newPas =md5(md5($_POST['password']).$salt);
$regdata = "INSERT INTO `users` (`login`, `pass`,`salt`) VALUES ( '{$_POST['login'] }','{$newPas }',' {$salt} ');";
$register = mysqli_query($link, $regdata) or die("Ошибка " . mysqli_error($link)); 
if (!$register)
{
	echo "Error :( </br>";
	echo $regdata;
}

else
	{
	echo "You have registered with data:  {$_POST['login']}  ,  {$newPas }  ,  {$salt}  </br>";
	$rep =md5(md5($_POST['password']).$salt);
	echo "REpeating  {$rep}  </br>";
	$rep2 =md5(md5($_POST['password']).$salt);
	echo "REpeating  {$rep2}  </br>";
	$rep3 =md5(md5($_POST['password']).$salt);
	echo "REpeating  {$rep3}  </br>";
	header("Location: ../old.php");
}




?>
<a class="nav" href="../old.php"> Old main page </a>