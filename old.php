<?php
    //  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
	
	$_SESSION['score'] = 0;
	
    ?>
    <html>
    <head>
	<meta charset="utf-8">
	<link rel = stylesheet href = "css\main.css">
    <title>Главная страница</title>
	<meta name='viewport'	 content=' width=device-width, user-scalable = yes'>
    </head>
    <body>

    <h1>Главная страница</h1>
	<?php 
	if(isset($_SESSION['message']))
		if(strlen($_SESSION['message']) > 0)
		{
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
	if(!empty($_SESSION['user']))
	
	{	
		$link = mysqli_connect("localhost","root","","users");
		echo "id: ".$_SESSION['u'];
		$sql = "SELECT `id` FROM `users` WHERE `login` = '{$_SESSION['user']}'";
		$res = mysqli_query($link,$sql) or die("Не удалось выполнить запрос: ".mysqli_error($link));
		$row = mysqli_fetch_row($res);
		echo "<a href = 'viewprofile.php?u={$row[0]}'> Личный кабинет </a>
				<form align = 'center' class= 'out' action='old.php' method = 'POST'>
				<input name='logout' type='submit' value = 'Выйти из аккаунта'> </br>
				</form>";
	}
	else 
	{		
		echo "
					<form   style = margin: auto; position:static; right:45%; width: 200px; border: 2px solid black; border-radius: 20px' width = '300px' action='accMng/login.php' method='post'> 
			
					
				 <p align = 'middle' >
					<label>Ваш логин:</br></label>
					<input name='login' type='text' size='15' maxlength='15'>
					</p>
					<p>
					<label>Ваш пароль:</br></label>
					<input name='password' type='password' size='15' maxlength='15'>
					</p>
					<p>
					<input type='submit' name='submit' value='Войти'>
				<br>

				<a href='accMng/registration.php'>Зарегистрироваться</a> 
					</p> </form> ";
	}
	
	?>
	<?php 
	if (isset($_POST['logout']))
	{
		unset($_SESSION['user']);
		unset($_SESSION['lvl']);
		header("Location: old.php");
	}
	?>
    </br>
    <?php
    // Проверяем, пусты ли переменные логина и id пользователя
    if (empty($_SESSION['user']))
    {
    // Если пусты, то мы не выводим ссылку
    echo "Вы вошли на сайт, как гость<br>";
    }
    else
    {

    // Если не пусты, то мы выводим ссылку
    echo "Вы вошли на сайт, как ".$_SESSION['user'];
    }

   
	// echo <iframe frameborder="0" style="border:none;width:30%;height:450px;" width="30%" height="450" src="https://music.yandex.ru/iframe/#playlist/asasnTV/3">Слушайте <a href='https://music.yandex.ru/users/asasnTV/playlists/3'>Мне нравится</a> — <a href='https://music.yandex.ru/users/asasnTV'>asasnTV</a> на Яндекс.Музыке</iframe>
	 ?>
	 <h2> <a href='viewforum.php?cat=0'> Вопросы </a></h2>
	<h3> Модули </h3>
	
	<a href = "modules\calculator.php"> Калькулятор </a> <br />
	<a href = "modules\wr.php"> Что больше </a> <br />
	<a href = "modules\health.php"> Моё здоровье </a> <br />
	<a href = "modules\kib.php"> Моё здоровье </a> <br />
	<?php 
	if (!empty($_SESSION['lvl']))
		if ($_SESSION['lvl'] > 1)
			echo "<a href = 'accMng/manage.php'> Управление аккаунтами </a> <br />";
	?>
	
	<?php 
	if (!empty($_SESSION['lvl']))
		if ($_SESSION['lvl'] > 1) 
			{
				echo session_id();
				echo "  ".$_SESSION['lvl'];
			}
	if(!empty($_SESSION['user']))
		
	{
		echo  "<div> ".$_SESSION['user'];
		echo "</br> {$_SESSION['lvl']} ";
	}
	?>
	<a href = "index.php"> </br> Main Page </a> <br />
    </body>
    </html>