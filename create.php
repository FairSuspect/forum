<?php session_start();
$link = mysqli_connect("localhost","root","","users");
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
<title>Создание</title>
</head>
<body>
<div class = 'quests'>
	<h3> Новая тема </h3>
	<hr>
	<?php 
	$sql = "SELECT `title` from `forums` WHERE `id` = {$_GET['f']}";
	$res = mysqli_query($link,$sql) or die("Ошибка при получении названия форума: ".mysqli_error($link));
	if($res)
		{
			$row = mysqli_fetch_row($res);
			echo "<a href='viewforum.php?f={$_GET['f']}'>{$row[0]}</a>";
		}
	?>
<?php echo "<form style = 'padding:10px;'method = 'POST' action='access.php?f={$_GET['f']}'>";?>
	<label> Заголовок</label> <br>
	<input type='text' name = 'title' required> <br><br>
	<label> Текст </label> <br>
	<textarea style = 'width: 25%; height: 10%;' name = 'text' required> </textarea><br><br>
	<input type='submit' name = 'submit'>  </input><br>


</div>
</body>

</html>