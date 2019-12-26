<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
	$link = mysqli_connect ("localhost","Kirill","q123123q","kirill_forum");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }
	   

    ?>
    <html>
    <head>
	<meta charset="utf-8">
	<link rel = stylesheet href = "..\css\viewforum.css">
    <title>Личный кабинет</title>
	<link rel = stylesheet href='css/viewprofile.css'>
    </head>
	<body style = 'font-size:12pt;' >
	<div class='quests'>
	<?php 

	if(isset($_SESSION['mess']))
	{
		echo "<div style = 'background-color: RGBA(30,255,30,0.4); padding: 10px; border: 1px solid black; border-radius: 5px; width: 20%; '>".$_SESSION['mess']."</div><br>";
		unset($_SESSION['mess']);
	}
	$sql = "SELECT * FROM `lk` WHERE `id` = '{$_GET['u']}'";

	$result = mysqli_query($link, $sql) or die("Ошибка: ".mysqli_error($link));
	if ($result)
	{
		
		$row = mysqli_fetch_row($result);
		$col = mysqli_query($link,"SELECT `lvl` FROM `users` WHERE `id` = '{$_GET['u']}'") or die("Ошибка при запросе lvl: ".mysqli_error($link));
		$color = mysqli_fetch_row($col);
		switch($color[0]){
		case 0: 
			$color='00C';
			break;
		case 1:
			$color='0C0';
			break;
		case 2:
			$color = 'C00';
			break;
		}
		if(isset($_SESSION['user']))	
			{
				$sqll = "SELECT login,lvl FROM `users` WHERE `login` = '{$_SESSION['user']}'";
				$res = mysqli_query($link,$sqll) or die("Ошибка при запросе id: ".mysqli_error($link));
				$user = mysqli_fetch_row($res);	
				if ($_SESSION['user'] == $user[0])
					{
						if(empty($row))
						{							
							echo "<br>Ваш личный кабинет ещё не настроен.<br>
							<form action = 'viewprofile.php?u={$_GET['u']}' method = 'POST'> <button name = 'set'> Настроить </button> </form>";					
						}
						else 
						{
							echo "<div class='inf'>";
							echo "Nickname: <span  style='font-weight:bold; color: #{$color};'>".$row[1]."</span><br>";
							echo "Имя: ".$row[2]."<br>";
							echo "Дата рождения: ".$row[3]."<br>
							Информация о себе: ".$row[5]."<br>";
							$sql = "SELECT
							(
							  (YEAR(CURRENT_DATE) - YEAR(birthday)) -
							  (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(birthday, '%m%d')) 
							) AS age
							FROM lk WHERE `id` = '{$_GET['u']}'";
							$tod = mysqli_query($link,$sql) or die("Ошибка при вычислении возраста: ".mysqli_error($link));
							if($tod)
							{
								$age = mysqli_fetch_row($tod);
								if($age)
									echo "Возраст: ".$age[0]."<br>";
							}
							echo "</div>";				
						}
					}	
			}
				else
					{

						if(empty($row))
						{							
							echo "<br>Пользователь еще не настроил свой личный кабинет.<br>";						
						}
						else 
						{
							echo "<div style = ' padding: 10px; width:50%; background-color: rgba(90,90,180,0.2); border: 1px solid #115511; font-size:20pt;'>";
							echo "Nickname: <span  style='font-weight:bold; color: #{$color};'>".$row[1]."</span><br>";
							echo "Имя: ".$row[2]."<br>";
							echo "Дата рождения: ".$row[3]."<br>
							Информация о пользователе: ".$row[5]."<br></div>";
						
						}
						
				
					} 
		
	}
	else die("!result");
	
	if (isset($_POST['set']))
	{
		echo "<form action = 'viewprofile.php?u={$_GET['u']}' method = 'POST'>
				<p>
				<label>Имя: <br> </label>
				<input type = 'text' name = 'name' size='20' maxlength='20'>
				</p>
				<p>
				<label>Дата рождения: <br> </label>
				<input type = 'date' name = 'date'>
				</p>
				<p>
				<label>Информация о себе: <br> </label>
				<input type = 'text' name = 'about' >
				</p> <br>
				<button name = 'confirm'> Готово </button>    
				<button name = 'cancel'> Отмена </button><br>
				</form>
		
		";
		
	}
	if (isset($_POST['confirm']))
	{
		$sql = "INSERT INTO `lk` (`id`,`login`,`name`,`birthday`,`about`) VALUES ('{$_GET['u']}','{$_SESSION['user']}','{$_POST['name']}', '{$_POST['date']}','{$_POST['about']}' )";
		$add = mysqli_query($link,$sql) or die("Ошибка при создании записи в таблице: ".mysqli_error($link));
		if ($add)
		{
			unset($_POST['set']);
			$_SESSION['mess'] = "Ваш личный кабинет настроен!";
			header("Location: viewprofile.php?u={$_GET['u']}");
			die();
		}
	}
	if (isset($_POST['cancel']))
		unset($_POST['set']);
	?>
	
	<a href = '../old.php'> Old </a>
	<form align = 'center' class= 'out' action='old.php' method = 'POST'>
				<input name='logout' type='submit' value = 'Выйти из аккаунта'> </br>
				</form>
</div>
	</body>
	
</html>