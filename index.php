<?php
session_start();
$link = mysqli_connect("localhost","kirill","q123123q","kirill_forum");
 if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	}
?>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport'	 content=' width=device-width, user-scalable = yes, initial-scale=1'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel = stylesheet href = "..\css\viewforum.css">
	<title> Форум </title>
</head>
<body>

<div class='quests'>
<header>
	<h1> ProgPeak Forum</h1>
	<h3> Форум программистов 
	<div style= 'margin-top:-15px' align= right> 
		<form method = GET action = viewforum.php>
			<input type =text name = search  value placeholder='Поиск...'required>
			<button> Найти </button>
		</form>
	</div>
	</h3>
</header>
<div class='nav' role = 'navigation'>
<a  href='index.php'><span class = 'icon fa-home fa-fw'> Главная страница </span></a>
<?php if (empty($_SESSION['user'])) 
		echo "<div align=right class=auth> <a href = auth.php?i=0&f=0> Вход </a> <a href = auth.php?i=1&f=0> Регистрация </a></div></div>";
	else 
	{
		$str = mysqli_query($link,"SELECT `id`,`lvl` FROM `users` WHERE `id`='{$_SESSION['u']}'");
		$id = mysqli_fetch_row($str);
		switch($id[1]){
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
		echo " <ul class='menu'>
		<li><div align=right class='auth log' style ='color: #{$color};'> {$_SESSION['user']}</div>
		 <ul> 
		  <li><a href='viewprofile.php?u={$_SESSION['u']}'>Профиль </a></li> 
		  <li><a href='logout.php'>Выйти из аккаунта</a></li> 
		 </ul> 
		</li> 
		</ul></div>";
		$sql = "SELECT * FROM `suspend` WHERE login='{$_SESSION['user']}'";
		$res = mysqli_query($link,$sql) or die("Ошибка при запросе: ".mysqli_error($link)) ;
		if ($res)
			if (mysqli_num_rows($res) == 0)
			{
				if($_SESSION['lvl']==2)
					echo "<div align = 'right' > <form action='create.php' method = GET> <button name = 'f' value = '0' style = 'width:150px; height: 25px; margin: 0 35px -5px 0;' > Создать раздел </button> </form></div>"; 
			}			
	}	
	if(isset($_SESSION['mes']))
	{
		echo $_SESSION['mes'];
		unset($_SESSION['mes']);
	}
?>
<table border='1px' class='quests'>
	
	<th width='60%'> Разделы</th>
	<th id='d770'> Тем </th>
	<th id ='d770'> Сообщений </th>
	<th id='d770'> Последнее сообщение </th>	
<?php 
$res = mysqli_query($link,"SELECT * FROM `forums`") or die("Ошибка: ".mysqli_error($link));
if($res)
{	
	$rows = mysqli_num_rows($res);
	for($i = 0; $i < $rows; $i++)
	{
		echo "<tr>";
		$row = mysqli_fetch_row($res);
		$f = $row[0];
		$ff = $i + 1;
		$sql1 = "SELECT `author`,`lastRepDate` FROM `topics` WHERE `category` = '{$ff}' ORDER BY `lastRepDate` DESC";
		$auth = "";
		$resul = mysqli_query($link,$sql1) or die ("Ошибка при получении автора: ".mysqli_error($link));
		if ($resul)
		{
			$a = mysqli_fetch_row($resul);
			$auth = $a[0];
			$time = $a[1];
		}
		$str = mysqli_query($link,"SELECT `id`,`lvl` FROM `users` WHERE `login`='{$auth}'");
		$id = mysqli_fetch_row($str);
		switch($id[1]){
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
		$res1 = mysqli_query($link,"SELECT category FROM `topics` WHERE `category` = {$f}");
		$topics = 0;
		if($res1)
			$topics = mysqli_num_rows($res1);
		$ress = mysqli_query($link,"SELECT category FROM `replies` WHERE `category` = {$f}");
		$messages = 0;
		if($ress)
			$messages = mysqli_num_rows($ress);
		
		$result = mysqli_query($link,"SELECT author FROM `topics` ORDER BY `lastRepDate` DESC") or die("Ошибка при получении автора: ".mysqli_error($link));
		if ($result)
			{
				$aut = mysqli_fetch_row($result);
				$str = mysqli_query($link,"SELECT `lvl` FROM `users` WHERE `login`='{$aut[0]}'");
				$id = mysqli_fetch_row($str);
				switch($id[0]){
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
				echo "<td> <a class='question' href='viewforum.php?f={$f}'>".$row[1]."</a><br><i style='font-size: 14px;'></i></td>";
				echo "<td id='d770' align='center'>{$topics}</td><td id='d770' align='center'>{$messages}</td><td id='d770' align='center'><a href = 'viewprofile.php?u={$id[0]}' style='font-size: 14px; color: #{$color};'>{$aut[0]}</a><br>{$time}</td></tr>";
			}
	}
}
?>
</table>
<br>
<footer> <nav style = 'text-align: center;'>
<a href = 'memberlist.php?p=0'> Список пользователей</a> |
<a href='logout.php'> Выйти из аккаунта </a>
</nav>
<hr>
<div style = 'font-size: 12pt; margin: 5px 0 5px 0'>
Легенда: <a href=memberlist.php?l=2 style = 'color: #C00'> Администраторы</a>, <a href=memberlist.php?l=1 style = 'color: #0C0'> Модераторы </a>
</div></footer></div></body></html>