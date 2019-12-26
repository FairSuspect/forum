<?php
session_start();
        $link = mysqli_connect ("localhost","Kirill","q123123q","kirill_forum");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }
	   else echo "Successful connect</br>";
$res= mysqli_query($link,"SELECT NOW()") or die("Ошибка при запросе времени ".mysqli_error($link));
$row = mysqli_fetch_row($res);
$time = $row[0];

$banlist = mysqli_query($link,"SELECT * FROM `suspend` WHERE `login`='{$_POST['login']}'") or die("Ошибка при выгрузке банов ".mysqli_error($link));
$isBanned = 0;
if($banlist)	
{
	echo "Банлист получен. <br>";
	$ban = mysqli_fetch_row($banlist);
		if($ban[1] > $time)
		{
			$isBanned = 1;	
			echo "Аккаунт в бане. <br>";
		}
		else 
			if($ban[1] < $time)
				{
				$sql = "DELETE FROM `suspend` WHERE `login` = '{$_POST['login']}'";
				$res = mysqli_query($link,$sql);
				if (!$res)
					die("Ошибка, не удалось стереть запись о бане: ".mysqli_error($link));
				}		
		$sql = "SELECT login, pass, salt, id FROM `users` WHERE `login`='{$_POST['login']}'";
		$result = mysqli_query($link, $sql) or die("Ошибка при выгрузке данных пользователей: ".mysqli_error($link)); 
		if($result)
		{
			if(mysqli_num_rows($result) == 0)
			{
				$_SESSION['message'] = "Такого пользователя не существует.";
				header("Location: ../auth.php?i=0&f={$_GET['f']}");
				exit;
			}
			$row = mysqli_fetch_row($result);
			echo $sql;
			
			$pas = md5(md5($_POST['password']).$row[2]);			
			echo "<div style = 'text-align: center; font-size: 20pt; color: gray;' > {$row[0]} </div>";
			if ($pas == $row[1])
				{	
					echo "<div style = 'text-align: center; font-size: 30pt; color: green;'> Successful login </br></div>";	
					$_SESSION['user'] = $_POST['login'];
					$_SESSION['u'] = $row[3];

					$lvl = mysqli_query($link, "SELECT `lvl` FROM `users` WHERE `users`.`login` = '{$_POST['login']}' ") or die("Ошибка " . mysqli_error($link)); 
					$row = mysqli_fetch_row($lvl);
					$_SESSION['lvl'] = $row[0];						
					echo "lvl is " ,$_SESSION['lvl'];
					echo "</br> User is " ,$_SESSION['user'];
					// die("</br>Всё ок ");					
				}
			else 
				if(strcasecmp($pas, $row[1]) != 0)
					{
						$_SESSION['message'] = "Неверный логин логин или пароль.";
					header("Location: ../auth.php?i=0&f={$_GET['f']}");
					exit;
					}
		}
}
if ($isBanned == 1)
		{
			header("Location: banned.php");
			die("На это странице больше делать нечего.");
		}
if(isset($_GET['f']))		
	{
		if($_GET['f']==0)
			header("Location: ../index.php");
		else header("Location: ../viewforum.php?f={$_GET['f']}");
	}
 else 
	 header("Location: ../index.php");
	 exit;
?>
<a class="nav" href="../old.php"> Old main page </a>