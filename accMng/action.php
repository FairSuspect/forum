<?php
session_start();
    $link = mysqli_connect ("localhost","kirill","q123123q","kirill_forum");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	}
	
if(isset($_POST['delete']))
{
	      
	$sql = "DELETE FROM `users` WHERE `users`.`id` = '{$_POST['delete']}'";
	$result = mysqli_query($link,$sql) or dir("Ошибка: ".mysqli_error($link));
	header("Location: ../memberlist.php?p=0");
	
}

if(isset($_POST['upgrade']))
{
	     
	$sql = "UPDATE `users` SET `lvl`= '1' WHERE `users`.`id` = '{$_POST['upgrade']}' ";
	$result = mysqli_query($link,$sql) or dir("Ошибка: ".mysqli_error($link));
	
	header("Location: ../memberlist.php?p=0");
}
if(isset($_POST['downgrade']))
{
	     
	$sql = "UPDATE `users` SET `lvl`= '0' WHERE `users`.`id` = '{$_POST['downgrade']}' ";
	$result = mysqli_query($link,$sql) or dir("Ошибка: ".mysqli_error($link));
	header("Location: ../memberlist.php?p=0");
}
if (isset($_POST['confirm']))
{
	
	
	$res= mysqli_query($link,"SELECT NOW() + {$_POST['time']}") or die("Ошибка ".mysqli_error($link));
	$row = mysqli_fetch_row($res);
	$time = $row[0];
	if($time)
	{
		"Ошибка";
	}
	echo $time."в таймстапе<br> ";
	$sql = "SELECT login FROM `suspend`";
	$result = mysqli_query($link,$sql);
	if(!$result)
		echo "Ошибка при полученнии данных с таблицы.";
	else 
	{
		$rows = mysqli_num_rows($result);
		echo $rows;
		for($i = 0; $i<$rows; $i++)
		{
			$row = mysqli_fetch_row($result);
			echo $row[0]." <br>";
			if($row[0] == $_POST['confirm'])
			{
				$ban = mysqli_query($link, "UPDATE `suspend` SET `time` = '{$time}', `punisher` = '{$_SESSION['user']}', `reason` = '{$_POST['reason']}' WHERE `login` =  '{$_POST['confirm']}'");
				if(!$ban)
				{
					die("Что-то пошло не так");
				}
				header("Location: ../memberlist.php?p=0");
				die("Почему ты ещё здесь?");
				
			}
		}
	}
	$sql = "INSERT INTO `suspend`(`login`, `time`, `reason`, `punisher`) VALUES ('{$_POST['confirm']}','{$time}','{$_POST['reason']}','{$_SESSION['user']}')";
	$ban =mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link)." Time is: ".$time);
	if(!$ban)
				{
					die("Что-то пошло не так");
				}
	header("Location: ../memberlist.php?p=0");
				die("Почему ты ещё здесь?");
}
if (isset($_GET['u']) && isset($_GET['key']))
{
	$sql = "SELECT `id`,`e-key` FROM `waiting` WHERE `id`={$_GET['u']}";
	$res = mysqli_query($link,$sql) or die("Ошибка при выгрузке списка неподтверждённых пользователей: ".mysqli_error($link));
	if($res)
	{
		$row = mysqli_fetch_row($res);
		if($_GET['u'] == $row[0] && $_GET['key'] == $row[1])
			{
				$sql = "UPDATE `users` SET `lvl`= '0' WHERE `users`.`id` = '{$_GET['u']}' ";
				$result = mysqli_query($link,$sql) or die("Ошибка: ".mysqli_error($link));
				if(!$result)
				{
					echo "Не вышло обновить уровень <br>";
					
				}
				else 
				{
					$sql = "DELETE FROM `waiting` WHERE `id` = '{$_GET['u']}'";
					$del = mysqli_query($link,$sql) or die("Ошибка: ".mysqli_error($link));
					if($del)
					{
						echo "Строчка из `waiting` удалена.";
					}
				}
				header("Location: ../old.php");
				$_SESSION['message'] = "<div style='max-width: 500px; margin: auto; border: 1px solid gray; background-color:#ccc;'> Ваша электронная почта подтверждена. Авторизуйтесь, чтобы пользоваться сайтом. </div>";
				
			}
		else 
			{
			echo "Невалидная ссылка.<br>";
			echo $_GET['u'];
			echo " : ";
			echo $row[0]."<br>";
			echo $_GET['key'];
			echo " : ";
			echo $row[1]."<br>";

			}

	}
	
	
}
die("Я нигде не был");
?>