<html>
<head>
<meta charset='utf-8'>
<meta http-equiv="Content-Type" content="text/html" />
<?php
$link = mysqli_connect ("localhost","kirill","q123123q","kirill_forum");
if (!$link) 
	{
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
		echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	$sql = "SELECT `title` from `topics` WHERE `id` = {$_GET['t']}";
	$res = mysqli_query($link,$sql) or die("Ошибка при получении названия топика: ".mysqli_error($link));
	if($res)
		{
			$row = mysqli_fetch_row($res);
			echo "<title> {$row[0]}</title>";
		}
	?>
 
<link rel = stylesheet href = "css\viewtopic.css"> 
<link rel = stylesheet href = "css\viewforum.css"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

</head>
<body>
<div class='quests'>	
<?php
session_start();
$_SESSION['mes'] = '';
?>
<header>
<a class = 'headerLink' style = 'text-decoration: none:' href = 'index.php'>
	<h1> ProgPeak Forum</h1> 
</a>
	<h3> Форум программистов 
	<div style= 'margin-top:-15px' align= right> 
	<?php // ----------------------------------- Поиск ------------------------------ //
	echo "	<form method = GET action = viewforum.php?f={$_GET['f']}> 
			<input type =text name = search value placeholder='Поиск...' required>
			<button name = f value = {$_GET['f']}> Найти </button>"; ?>
		</form>
	</div>
	</h3>
</header>
<div class='nav' role = 'navigation'>
	<div>
	<a  href='index.php'><span class = 'icon fa-home fa-fw'> Главная страница </span></a>
	<?php 
		$sql = "SELECT `title` from `forums` WHERE `id` = {$_GET['f']}";
		$res = mysqli_query($link,$sql) or die("Ошибка при получении названия форума: ".mysqli_error($link));
		if($res)
			{
				$row = mysqli_fetch_row($res);
				echo "<span class= bef> <a href='viewforum.php?f={$_GET['f']}'>{$row[0]}</a></span> ";
				$sql = "SELECT `title` from `topics` WHERE `id` = {$_GET['t']}";
				$res = mysqli_query($link,$sql) or die("Ошибка при получении названия топика: ".mysqli_error($link));
				if($res)
				{
					$row = mysqli_fetch_row($res);
					echo "<span class= bef> <a href='viewtopic.php?f={$_GET['f']}&t={$_GET['t']}'>{$row[0]}</a></span> ";
				}
			}
	?>
	</div>
	<?php
	if (empty($_SESSION['user'])) 
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
<?php
	if(isset($_GET['p']))
	{
		if($_GET['p']>0)
		{
			echo "<nav>";
			$sql = "SELECT id FROM `replies` WHERE `parent`='{$_GET['t']}' ";
			$res = mysqli_query($link,$sql) or die("Ошибка при полчении количества ответов: ".mysqli_error($link));
			if ($res)
			{
				$pages = mysqli_num_rows($res)/10;
				$page = $_GET['p'];
				for($i = 1; $i < $pages; $i++)
				{
					if($i == $page)
						echo "<div class='navS'> {$i} </div>";
					else 
						echo "<a href='viewtopic.php?f={$_GET['f']}&t={$_GET['t']}&p={$i}'><div class='page'> {$i} </div></a>";
				}
				echo "</nav>";
			}
		}
	}
	else{
			$sql = "SELECT id FROM `replies` WHERE `parent`='{$_GET['t']}' ";
			$res = mysqli_query($link,$sql) or die("Ошибка при полчении количества ответов: ".mysqli_error($link));
			if ($res)
			{
				$pages = mysqli_num_rows($res)/10;
				$page = 1;
				for($i = 1; $i < $pages; $i++)
				{
					if($i == $page)
						echo "<div class='navS'> {$i} </div>";
					else
						echo "<a href='viewtopic.php?f={$_GET['f']}&t={$_GET['t']}&p={$i}'><div class='page'> {$i} </div></a>";
				}
				echo "</nav>";
			}
	}
if(isset($_SESSION['user']))
{
	$req = "SELECT `lvl` FROM `users` WHERE `login` = '{$_SESSION['user']}'";
	$request = mysqli_query($link,$req);
	if ($request)
	{
		$lvl = mysqli_fetch_row($request);
	}
}
$sql = "SELECT * FROM `topics` WHERE `category`='{$_GET['f']}' AND `id`='{$_GET['t']}'";
$res = mysqli_query($link,$sql) or die("Ошибка при выгрузке вопроса: ".mysqli_error($link));
if($res)
{	
	$row = mysqli_fetch_row($res);
	if(empty($row))
	{
		die("<div class='topic'> Данного топика не существует. <br> Понятно, назад к <a href='viewforum.php?f={$_GET['f']}'>вопросам</a>.");
	}
	$str = mysqli_query($link,"SELECT `id`,`lvl` FROM `users` WHERE `login`='{$row[1]}'");
	$id = mysqli_fetch_row($str);
	$f = $row[5]; // id категории
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
		echo "<div class='topic'><h3>".$row[2]."</h3> <div> <a class = 'user' style=' color: #{$color};' href='viewprofile.php?u={$id[0]}'> {$row[1]}</a> {$row[4]}";
		if (isset($_SESSION['user']))
			if ($row[1]==$_SESSION['user'] || $lvl[0] > 0)
			{
				echo "<form style='text-align: right;' action='access.php?f={$_GET['f']}' method='POST'>";
				echo "<button name = 'del' value ='{$row[0]}' style='color:white; background-color:red'> X </button>";
				echo "<button name = 'upd' value = '{$row[0]}'> Доб. </button> </form>";
			}
			echo "</div>";
		echo "<div style= 'padding:10px; background-color:rgba(240,240,240,0.9); border: 1px solid black; '>
		{$row[3]}";
		if(!empty($row[9]))
			echo "<div style='text-align:right; font-size: 12pt;'>Последний раз обновлялось: {$row[9]} </div>";
		echo "</div></div>";
}
$sql = "";
if(isset($_GET['p']))
{
	$first = 10*($_GET['p']-1);
	$sec = $first + 10;
	$sql = "SELECT * FROM `replies` WHERE `parent` = '{$_GET['t']}' LIMIT {$first},{$sec}";
}
else 
	$sql = "SELECT * FROM `replies` WHERE `parent` = '{$_GET['t']}' LIMIT 0,10";
$res = mysqli_query($link,$sql) or die("Ошибка при загрузке ответов: ".mysqli_error($link));
if($res)
{
	$rows = mysqli_num_rows($res);
	for($i = 0; $i < $rows; $i++)
	{
		$row = mysqli_fetch_row($res); 
		$str = mysqli_query($link,"SELECT `id`,`lvl` FROM `users` WHERE `login`='{$row[1]}'");
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
		echo "<div class='topic'>
				<dl class = 'user'>
				<dt><a class = 'user' style=' color: #{$color};' href='viewprofile.php?u={$id[0]}'>  {$row[1]}</a></dt> 
				<dd>{$row[3]}</dd>";
				$str = mysqli_query($link,"SELECT * FROM `lk` WHERE `login`='{$row[1]}'");
				$inf = mysqli_fetch_row($str); // информация из личного кабинета
				if (!empty($inf))
				{
					echo "<dd><strong>Имя:</strong> {$inf[2]} </dd>";
				}
				if (isset($_SESSION['user']))
					if ($row[1]==$_SESSION['user'] || $lvl[0] > 0)
					{
						echo "<form align = 'right' action='access.php?f={$_GET['f']}' method='POST'>";
						echo "<button name = 'delRep' value ='{$row[4]}' style='color:white; background-color:red'> X </button>";
					}
				echo " </dl>"; 
				/*echo "<div class='postBody'>
				{$row[2]} 
				</div>";
				*/				
				//        Возможный фикс использования HTML тэгов (не работает из-за ДОМ)
				?>
				<script>
				
					<?php echo "let text{$i} = document.createElement('div'); ";
					echo "text{$i}.setAttribute('class','postBody');";
					
					echo "var node{$i} = document.createElement('div');";
					echo "node{$i}.innerText = '{$row[2]}';";
					
					echo "text{$i}.appendChild('node{$i}');";
						
					echo "let divP{$i} = document.getElementsByClassName('topic')[{$i}];";
					
					echo "divP.appendChild('text{$i}');";
					?>
					</script>
					<?php
					
		echo "</div>";
	}
}
if(empty($_SESSION['user']))
	echo "<br> <br><div style = 'padding: 10px;border: 1px solid black; background-color:rgba(100,100,255,0.4); width: 25%;'>
<a href='old.php'> Войдите</a> или <a href = '/accMng/registration.php'> зарегистрируйтесь</a>, чтобы ответить.</div>";
else
{
	$link = mysqli_connect("localhost","kirill","q123123q","kirill_forum");
	$sql = "SELECT * FROM `suspend` WHERE login='{$_SESSION['user']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при запросе: ".mysqli_error($link)) ;
	if ($res)
		if (mysqli_num_rows($res) != 0)
		{
			echo "<br> <br><div style = 'padding: 10px;border: 1px solid black; background-color:rgba(100,100,255,0.4); width: 25%;'>
			Вы не можете отвечать на вопросы, т.к. ваш аккаунт <a href='accMng/banned.php'> заморожен</a>.</div>";
		}
		else
			echo "<form style = 'padding:10px;'method = 'POST' action='access.php?f={$_GET['f']}'>
				<label> Быстрый ответ </label> <br>
				<textarea rows = 7 col = 21  name = 'text' required> </textarea><br><br>
				 <button name = 'submitRep' value = '{$_GET['t']}'> Отправить </button><br></form>"; 
}				
?>
<br>
<?php
if(isset($_GET['p']))
{
	if($_GET['p']>0)
	{
		echo "<ul>";
		$sql = "SELECT id FROM `replies` WHERE `parent`='{$_GET['t']}' ";
		$res = mysqli_query($link,$sql) or die("Ошибка при полчении количества ответов: ".mysqli_error($link));
		if ($res)
		{
			$pages = mysqli_num_rows($res)/10;
			$page = $_GET['p'];
			for($i = 1; $i < $pages+1; $i++)
			{
				if($i == $page)
					echo "<li class='navS'> {$i} </li>";
				else 
					echo "<a href='viewtopic.php?f={$_GET['f']}&t={$_GET['t']}&p={$i}'><li class='page'> {$i} </li></a>";
			}			
		}
		echo "</ul>";
	}
	else 
	{
			header("Location: viewtopic.php?t={$_GET['t']}&f={$_GET['f']}");
			exit;					
	}
}
else{
		$sql = "SELECT id FROM `replies` WHERE `parent`='{$_GET['t']}' ";
		$res = mysqli_query($link,$sql) or die("Ошибка при полчении количества ответов: ".mysqli_error($link));
		if ($res)
		{
			$pages = mysqli_num_rows($res)/10;
			$page = 1;
			echo "<ul>";
			for($i = 1; $i < $pages; $i++)
			{
				if($i == $page)
					echo "<li class='navS'> {$i} </li>";
				else
					echo "<a href='viewtopic.php?f={$_GET['f']}&t={$_GET['t']}&p={$i}'><li class='page'> {$i} </li></a>";
			}
			echo "</ul></nav>";
		}
}
?>
<?php echo "<a href='viewforum.php?f={$_GET['f']}'> Назад </a><br>"; ?>
<br>
<footer> 
<nav style = 'text-align: center;'>
<a href = 'memberlist.php?p=0'> Список пользователей</a> |
<?php
if(!empty($_SESSION['user']))
	echo "<a href='logout.php'> Выйти из аккаунта </a>";
?>
</nav><hr>
<div style = 'font-size: 12pt; margin: 5px 0 5px 0'>
Легенда: <a href='memberlist.php?l=2' style = 'color: #C00'> Администраторы</a>, <a href='memberlist.php?l=1' style = 'color: #0C0'> Модераторы </a>
</div></footer></div></body></html>