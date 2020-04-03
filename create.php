<?php session_start();
$link = mysqli_connect ("localhost","kirill","q123123q","kirill_forum");
if (!$link) 
	{
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
		echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
if(!isset($_GET['f']) or !isset($_SESSION['lvl']))
	{
		header("Location: index.php");
		exit;
	}
elseif ($_GET['f'] == 0 && $_SESSION['lvl'] < 2 )
	{
		header("Location: index.php");
		exit;
	}
	elseif ($_SESSION['lvl'] < 1)
	{
		header("Location: index.php");
		exit;
	}
 ?>
<html>
<head>
<meta charset='utf-8'>
<link rel = stylesheet href='css/viewforum.css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<title>Создание</title>
</head>
<body>
<div class = 'quests'>
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
	}	
?>
	<h3> Новая тема </h3>
	<hr>
	<?php 
	if(isset($_GET['f']))
		if($_GET['f']!= 0)
		{
		$sql = "SELECT `title` from `forums` WHERE `id` = {$_GET['f']}";
		$res = mysqli_query($link,$sql) or die("Ошибка при получении названия форума: ".mysqli_error($link));
		if($res)
			{
				$row = mysqli_fetch_row($res);
				echo "<a href='viewforum.php?f={$_GET['f']}'>{$row[0]}</a>";
			}}
	?>
<?php echo "<form style = 'padding:10px;'method = 'POST' action='access.php?f={$_GET['f']}'>";?>
	<label> Заголовок</label> <br>
	<input type='text' name = 'title' required> <br><br>
	<label> Текст </label> <br>
	<textarea style = 'width: 25%; height: 10%;' name = 'text' required></textarea><br><br>
	<input type='submit' name = 'submit'>  </input><br>
	<br>
<footer> <nav style = 'text-align: center;'>
<a href = 'memberlist.php?p=0'> Список пользователей</a> |
<a href='logout.php'> Выйти из аккаунта </a>
</nav>
<hr>
<div style = 'font-size: 12pt; margin: 5px 0 5px 0'>
Легенда: <a href=memberlist.php?l=2 style = 'color: #C00'> Администраторы</a>, <a href=memberlist.php?l=1 style = 'color: #0C0'> Модераторы </a>
</div></footer></div></body></html>