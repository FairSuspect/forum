<?php
session_start();
//$_SESSION['dir'] =PHP_INT_MIN;
//die($_SESSION['dir']);
$link = mysqli_connect("localhost","root","","users");
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
<?php
if(!isset($_GET['search']))
{
	$sql = "SELECT `title` from `forums` WHERE `id` = {$_GET['f']}";
$res = mysqli_query($link,$sql) or die("Ошибка при получении названия топика: ".mysqli_error($link));
if($res)
	{
		$row = mysqli_fetch_row($res);
		echo "<title> {$row[0]}</title>";
	}	
}
else echo "<title> Поиск</title>"
?>
<head>
<body>

<div class='quests'>
<div class='header'>
	<h1> Крутой форум </h1>
</div>
<div class='nav' role = 'navigation'>
	<span class = 'icon fa-home fa-fw'><a  href='index.php'> Главная страница </a></span>
	<?php 
	if(isset($_GET['search']))
		echo "<span class= bef>  Поиск</a></span>";
	else
	 {
		$sql = "SELECT `title` from `forums` WHERE `id` = {$_GET['f']}";
		$res = mysqli_query($link,$sql) or die("Ошибка при получении названия форума: ".mysqli_error($link));
		if($res)
			{
				$row = mysqli_fetch_row($res);
				echo "<span class= bef> <a href='viewforum.php?f={$_GET['f']}'>{$row[0]}</a></span>";
			}
	}
	?>
</div>
<?php 
if(!isset($_GET['search']))
{
if (empty($_SESSION['user'])) 
	echo "<div class='makeQ'>
<a href='old.php'> Войдите</a> или <a href = '/accMng/registration.php'> зарегистрируйтесь</a>, чтобы ответить.</div>";
else 
	{
		$link = mysqli_connect("localhost","root","","users");
		$sql = "SELECT * FROM `suspend` WHERE login='{$_SESSION['user']}'";
		$res = mysqli_query($link,$sql) or die("Ошибка при запросе: ".mysqli_error($link)) ;
		if ($res)
			if (mysqli_num_rows($res) != 0)
			{
				echo "<br> <br><div  class = 'makeQ'>
				Вы не можете задавать вопросы, так как ваш аккаунт <a href='accMng/banned.php'> заморожен</a>.</div>";
			}
			else 
				echo "<div align = 'right' > <form action='create.php' method = 'GET'> <button style = 'width:150px; height: 25px; margin: 0 35px -5px 0;' name='f' value = '{$_GET['f']}' > Новая тема</button> </form></div>"; 
	}

	}	
	
?>

<table border='1px' class='quests'>
	
	<th width='60%'> Вопросы / Автор</th>
	<th id='d770'> Ответов </th>
	<th id ='d770'> Просмотров </th>
	<th id='d770'> Последнее сообщение </th>
	
<?php 
if(isset($_GET['search']))
	if(isset($_GET['f']))
		$sql ="SELECT * FROM `topics` WHERE `category` = '{$_GET['f']}'AND `title` LIKE '%{$_GET['search']}%' ORDER BY `lastRepDate` DESC";
	else $sql ="SELECT * FROM `topics` WHERE `title` LIKE '%{$_GET['search']}%' ORDER BY `lastRepDate` DESC";
else 
	$sql = "SELECT * FROM `topics` WHERE `category` = '{$_GET['f']}' ORDER BY `lastRepDate` DESC";
$res = mysqli_query($link,$sql) or die("Ошибка: ".mysqli_error($link));
if($res)
{	
	$rows = mysqli_num_rows($res);
	for($i = 0; $i < $rows; $i++)
	{
		echo "<tr>";
		$row = mysqli_fetch_row($res);
		$f = $row[5]; // id категории
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
		$replies = mysqli_num_rows(mysqli_query($link,"SELECT parent FROM `replies` WHERE `parent` = {$row[0]}"));
		echo "<td> <a class='question' href='viewtopic.php?f={$f}&t={$row[0]}'>".$row[2]."</a><br><i style='font-size: 14px;'> <span class = bef> </i><a  style='font-size: 14px; color: #{$color};' href='viewprofile.php?u={$id[0]}'>    {$row[1]}</a></span></td>";
		$str = mysqli_query($link,"SELECT `lvl` FROM `users` WHERE `login`='{$row[6]}'");
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
		echo "<td id='d770' align='center'>{$replies}</td><td id='d770' align='center'>{$row[8]}</td><td id='d770' align='center'><a href = 'viewprofile.php?u={$id[0]}' style='font-size: 14px; color: #{$color};' >{$row[6]}</a><br>{$row[7]}</td></tr>";
	}
}
?>
</table>
<?php
if(!isset($_GET['search']))
	if($_SESSION['lvl']==2)
	{
		echo "<div align= right><form action='access.php?f={$_GET['f']}' method=POST>
		<button name=delF value = {$_GET['f']}> Удалить раздел </button>
		</form></div>";

	}
?>
<nav style = 'text-align: center;'>
<a href='old.php'> Назад на главную</a> | 
<a href = 'memberlist.php?p=0'> Список пользователей</a> |
<a href='logout.php'> Выйти из аккаунта </a>
</nav>
</div>
</body>
</html>