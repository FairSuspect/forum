<html>


<head>
<meta name='viewport'	 content=' width=device-width, user-scalable = yes'>
</head>
<?php
session_start() ;
	$link = mysqli_connect ("localhost","root","","users");
    if (!$link) 
	{
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
		echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	   }
	
if(isset($_POST['submit']))
{
	$date = mysqli_query($link,"SELECT NOW()");
	$time= mysqli_fetch_row($date);
	echo $time[0];
	$sql = "INSERT INTO `topics`(`author`,`title`,`text`,`category`,`lastRepAut`,`lastRepDate`) VALUES ('{$_SESSION['user']}','{$_POST['title']}','{$_POST['text']}','0','{$_SESSION['user']}','{$time[0]}')";
	$res = mysqli_query($link, $sql) or die("Ошибка: ".mysqli_error($link));
	if ($res)
	{
		echo "<div style = 'padding:10px;background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Вопрос успешно создан! </div>";
		
	}
	echo "<a href='viewforum.php?c=0'> Назад к вопросам</a>";
	
}


if(isset($_POST['submitRep']))
{
	$sql = "INSERT INTO `replies`(`author`,`text`,`parent`) VALUES ('{$_SESSION['user']}','{$_POST['text']}','{$_POST['submitRep']}')";
	$res = mysqli_query($link, $sql) or die("Ошибка: ".mysqli_error($link));
	if ($res)
	{
		echo "<div style = 'padding: 10px; background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Ответ успешно создан! </div>";
		
	}
	echo "<a href='viewforum.php?cat=0'> Назад к вопросам</a>";
	if(isset($_SESSION['dir']))
		echo "<br> <a href = {$_SESSION['dir']}> Назад к теме</a>";
	$time = mysqli_query($link,'SELECT NOW()') or die("Не удалось получить текущее время: ".mysqli_error($link));
	$date = mysqli_fetch_row($time);
	$idd = mysqli_query($link,"SELECT id, login,lvl FROM users WHERE `login` = '{$_SESSION['user']}'") or die("Ошибка при получении id: ".mysqli_error($link));
	$ids = mysqli_fetch_row($idd);
	switch($ids[2]){
		case 0:  $color = '00A';
		break;
		case 1: $color = '0A0';
		break;
		case 2: $color = 'A00';
		break;
		default: $color = '000';
	}
	
$sql = <<<EOT
UPDATE `topics` SET  lastRepAut='{$_SESSION['user']}', lastRepDate = '{$date[0]}' WHERE `id` = {$_POST['submitRep']};
EOT;
	$res = mysqli_query($link, $sql) or die("Ошибка при обновлении `topics` : ".mysqli_error($link));
}

?>

</html>