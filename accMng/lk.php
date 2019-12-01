<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
	$link = mysqli_connect ("localhost","root","","users");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }
	   
$sql = "SELECT login, id FROM `users` WHERE `users`.`login` = '{$_SESSION['user']}' ";
$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link)); 
    ?>
    <html>
    <head>
	<meta charset="utf-8">
	<!-- <link rel = stylesheet href = "..\css\main.css"> --->
    <title>Личный кабинет</title>
	
    </head>
    <body>
	<?php 
	$row = mysqli_fetch_row($result);
	$id = $row[1];
	echo "Это ваш личный кабинет, {$row[0]} <br>";
	if(isset($_SESSION['mess']))
	{
		echo "<div style = 'background-color: RGBA(30,255,30,0.4); padding: 10px; border: 1px solid black; border-radius: 5px; width: 20%; '>".$_SESSION['mess']."</div><br>";
		unset($_SESSION['mess']);
	}
	$check = 0;
	$result = mysqli_query($link, "SELECT * FROM lk") or die("Ошибка: ".mysqli_error($link));
	if ($result)
	{
		$rows = mysqli_num_rows($result);
		for ($i  = 0; $i < $rows; $i++)
		{
			
			$row = mysqli_fetch_row($result);
			if ($row[1] == $_SESSION['user'])
			{
				$check = 1;
				break;
			}
		}
		if ($check == 0)
		{
			echo "<br>Ваш личный кабинет ещё не настроен.<br>
			<form action = 'lk.php' method = 'POST'> <button name = 'set'> Настроить </button> </form>";
			
		}
		else {
			echo "<div style = ' padding: 10px; width:50%; background-color: rgba(90,90,180,0.2); border: 1px solid #115511; font-size:20pt;'>";
			echo "Имя: ".$row[2]."<br>";
			echo "Дата рождения: ".$row[3]."<br>
				Информация о себе: ".$row[5]."<br></div>
			";
		}
		 
	}
	else die("!result");
	
	if (isset($_POST['set']))
	{
		echo "<form action = 'lk.php' method = 'POST'>
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
		$sql = "INSERT INTO `lk` (`id`,`login`,`name`,`dateOfBirth`,`about`) VALUES ('{$id}','{$_SESSION['user']}','{$_POST['name']}', '{$_POST['date']}','{$_POST['about']}' )";
		$add = mysqli_query($link,$sql) or die("Ошибка при создании записи в таблице: ".mysqli_error($link));
		if ($add)
		{
			unset($_POST['set']);
			$_SESSION['mess'] = "Ваш личный кабинет настроен!";
			header("Location: lk.php");
			die ();
		}
	}
	if (isset($_POST['cancel']))
		unset($_POST['set']);
	?>
	
	<a href = '../old.php'> Old </a>
	<form align = 'center' class= 'out' action='../old.php' method = 'POST'>
				<input name='logout' type='submit' value = 'Выйти из аккаунта'> </br>
				</form>
	</body>
	
</html>