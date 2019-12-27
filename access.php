<html><head>
	<meta name='viewport'	 content=' width=device-width, user-scalable = yes'>
<link rel = stylesheet href='/css/viewforum.css'>
<link rel = stylesheet href = "css\viewtopic.css"> 
</head>
<body>
	<div class = 'quests'>
<?php
session_start() ;
	$link = mysqli_connect ("localhost","kirill","q123123q","kirill_forum");
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
	if($_GET['f']!=0)
	{	
		$sql = "INSERT INTO `topics`(`author`,`title`,`text`,`category`,`lastRepAut`,`lastRepDate`) VALUES ('{$_SESSION['user']}','{$_POST['title']}','{$_POST['text']}','{$_GET['f']}','{$_SESSION['user']}','{$time[0]}')";
		$res = mysqli_query($link, $sql) or die("Ошибка: ".mysqli_error($link));
		if ($res)
			echo "<div style = 'padding:10px;background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Тема успешно создана! </div>";		
		$res = mysqli_query($link, "SELECT `id` FROM `topics` ORDER BY `id` DESC") or die("Ошибка при получении id: ".mysqli_error($link));
		if ($res)
		{
			$row = mysqli_fetch_row($res);
			header("Location: viewtopic.php?f={$_GET['f']}&t={$row[0]}");		
		}	
		echo "<a href='viewforum.php?f={$_GET['f']}'> Назад к разделу</a>";
		exit;
	}
	else 
	{
		$sql = "INSERT INTO `forums`(`title`) VALUES ('{$_POST['title']}')";
		$res = mysqli_query($link, $sql) or die("Ошибка: ".mysqli_error($link));
		if ($res)
			echo "<div style = 'padding:10px;background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Тема успешно создана! </div>";			
		echo "<a href='viewforum.php?f={$_GET['f']}'> Назад к разделу</a>";
	}
}
if(isset($_POST['del'])) // удаление топика
{
	
	$sql = "DELETE FROM `topics` WHERE `id` = '{$_POST['del']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при удалении топика: ".mysqli_error($link)."id: {$_POST['del']}");
	if($res)
		echo "<div style = 'padding: 10px; background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Ваша тема была успешно удалена! </div>";
	$sql = "DELETE FROM `replies` WHERE `parent` = '{$_POST['del']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при удалении ответов на топик: ".mysqli_error($link));
	if ($res)
		echo "<br> <a href = 'viewforum.php?f={$_GET['f']}'>Назад к темам</a>";	
}

if(isset($_POST['delRep'])) // удаление одного ответа
{
	$sql = "SELECT `parent` FROM `replies` WHERE `id` = '{$_POST['delRep']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при выгрузке родителя: ".mysqli_error($link));
	if($res)
	{
		echo $_POST['delRep'];
		$parent = mysqli_fetch_row($res);
		$sql = "DELETE FROM `replies` WHERE `id` = '{$_POST['delRep']}'";
		$resul = mysqli_query($link,$sql) or die("Ошибка при удалении ответа: ".mysqli_error($link)."id: {$_POST['delRep']}");
		if($resul)
		{
			$sqll = "SELECT `author`,`postDate` FROM `replies` WHERE `parent` = '{$parent[0]}' ORDER BY `postDate` DESC";
			$result = mysqli_query($link,$sqll) or die("Ошибка при обнволении последнего ответа: ".mysqli_error($link));
			if($result)
			{
				if(mysqli_num_rows($result) == 0 )
					{
						$sql = "SELECT `author`,`postDate` FROM `topics` WHERE `id` = '{$parent[0]}'";
						$aut = mysqli_query($link,$sql) or die("Ошибка при установке автора и ответа: ".mysqli_error($link));
						if($aut)
						{

							$author = mysqli_fetch_row($aut);
							$upd = "UPDATE `topics` SET `lastRepAut`='{$author[0]}',`lastRepDate` = '{$author[1]}' WHERE `id`='{$parent[0]}'";
							$update = mysqli_query($link,$upd) or die("Ошибка при установке автора и ответа: ".mysqli_error($link));
							if($update)
							{
								echo "<div style = 'padding: 10px; background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Ответ успешно удалён! </div>";
								echo "<a href='viewforum.php?f={$_GET['f']}'> Назад к разделу </a>";
							}
							
						}
					}
				else 
				{
					$row = mysqli_fetch_row($result);
					$upd = "UPDATE `topics` SET `lastRepAut`='{$row[0]}',`lastRepDate` = '{$row[1]}' WHERE `id`='{$parent[0]}'";
					$update = mysqli_query($link,$upd) or die("Ошибка при установке автора и ответа: ".mysqli_error($link));
					if($update)
					{
						echo "<div style = 'padding: 10px; background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Ваш вопрос был успешно удалён! </div>";
						echo "<a href='viewforum.php?f={$_GET['f']}'> Назад, к вопросам </a>";		
					}
				}

			}
					
		}
	}
}
if(isset($_POST['submitRep'])) // отправка ответа
{
	$sql = "INSERT INTO `replies`(`author`,`text`,`parent`,`category`) VALUES ('{$_SESSION['user']}','{$_POST['text']}','{$_POST['submitRep']}','{$_GET['f']}')";
	$res = mysqli_query($link, $sql) or die("Ошибка: ".mysqli_error($link));
	
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
	header("Location: viewtopic.php?f={$_GET['f']}&t={$_POST['submitRep']}");
	die("<div style = 'padding: 10px; background-color: rgba(50,255,50,0.4); border: 1px solid black; width: 25%; margin: auto;'>Ответ успешно создан! </div><a href='viewforum.php?f={$_GET['f']}'> Назад к вопросам</a>");
}
if(isset($_POST['upd']))
{
	echo "Добавление к сообщению: <br>";
$sql = "SELECT text FROM `topics` WHERE `id` = '{$_POST['upd']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при выгрузке текста топика: ".mysqli_error($link));
	if($res)
	{
		$row = mysqli_fetch_row($res);
		echo "<div class='quests'>".$row[0]."</div>";
	}
	echo "<form action='access.php' method='POST'>
		<textarea name='upd'> </textarea>
		<button name='updB' value = {$_POST['upd']} > Сохранить </button>
		</form>";
}
if(isset($_POST['updB']))
{
$sql = "SELECT `lastUpd` FROM `topics` WHERE `id` = {$_POST['updB']}";
$result = mysqli_query($link,$sql) or die("Ошибка при получении даты последнего UPD: ".mysqli_error($link));
if($result)
	{
		$upd = mysqli_fetch_row($result);
		
		
			$sql = <<<EOC
				UPDATE `topics` SET `text` = CONCAT(text,' ','<br><div class="upd"> {$_POST["upd"]} </div>'), `lastRepDate` = NOW() WHERE `id`='{$_POST['updB']}'
				EOC;
				$res = mysqli_query($link,$sql) or die("Ошибка при добавлении текста: ".mysqli_error($link));
				if($res)
				{
					if(!empty($row))
					{
						echo "Создаю новую запись об UPD";
						$sql = "INSERT INTO `topics` (`lastUPD`) VALUES( = NOW())";
						$UPD = mysqli_query($link,$sql) or die("Ошибка при добавлении времени последнего UPD: ".mysqli_error($link));
					}
					else 
					{
						$sql = "UPDATE  `topics` SET `lastUPD` = NOW()";
						$UPD = mysqli_query($link,$sql) or die("Ошибка при обновлении времени последнего UPD: ".mysqli_error($link));
					}
				header("Location: viewtopic.php?f={$_GET['f']}&t={$_POST['updB']}");
				exit;
				}
	}
}
if(isset($_POST['delF']))
{
	echo "Вы действительно хотите удалить раздел {$_POST['delF']}?
	<form action = access.php method=POST>
	<button name = yes value = {$_POST['delF']}> Да </button>
	<button name = no> Нет </button> 
	</form>";
}
if(isset($_POST['yes']))
{
	$sql = "DELETE FROM `forums` WHERE `id` = '{$_POST['yes']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при удалении: ".mysqli_error($link));
	if($res)
	{
		header("Location: index.php");
		exit;
	}
}
?></div></body></html>