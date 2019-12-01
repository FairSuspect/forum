<html>
<head>
<meta charset='utf-8'>
<title> Вопрос </title> 
<link rel = stylesheet href = "css\viewtopic.css"> 
</head>
<body>
<div class='quests'>
<?php
session_start();
$_SESSION['mes'] = '';
//$_SESSION['dir'] =__FILE__;

        $link = mysqli_connect ("localhost","root","","users");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }   
$sql = "SELECT * FROM `topics` WHERE `category`='{$_GET['cat']}' AND `id`='{$_GET['t']}'";
$res = mysqli_query($link,$sql) or die("Ошибка при выгрузке вопроса: ".mysqli_error($link));
if($res)
{
	
	$row = mysqli_fetch_row($res);
	$str = mysqli_query($link,"SELECT `id` FROM `users` WHERE `login`='{$row[1]}'");
	$id = mysqli_fetch_row($str);
	$cat = $row[5]; // id категории

		echo "<div class='quests'><h3>".$row[2]."</h3> <div style='text-align:right'> Вопрос задал <a href='viewprofile.php?u={$id[0]}'> {$row[1]} </a>, {$row[4]} </div>
		<div style= 'padding:10px; background-color:rgba(240,240,240,0.9); border: 1px solid black'>
		{$row[3]}
		
		</div></div>";
		
		
	
	
}
$sql = "SELECT * FROM `replies` WHERE `parent` = '{$_GET['t']}'";
$res = mysqli_query($link,$sql) or die("Ошибка при загрузке ответов: ".mysqli_error($link));
if($res)
{
	$rows = mysqli_num_rows($res);
	for($i = 0; $i < $rows; $i++)
	{
		$row = mysqli_fetch_row($res);
		$str = mysqli_query($link,"SELECT `id` FROM `users` WHERE `login`='{$row[1]}'");
		$id = mysqli_fetch_row($str);
		echo "<div class='quests'><dl style='text-align:left'><dt><a href='viewprofile.php?u={$id[0]}'>  {$row[1]}</a></dt> {$row[3]} </dl>
		<div style= 'padding:10px; background-color:rgba(240,240,240,0.9); border: 1px solid black'>
		{$row[2]}
		
		</div></div>";
		
		
	}
	
}


if(empty($_SESSION['user']))
	echo "<br> <br><div style = 'padding: 10px;border: 1px solid black; background-color:rgba(100,100,255,0.4); width: 25%;'>
<a href='old.php'> Войдите</a> или <a href = '/accMng/registration.php'> зарегистрируйтесь</a>, чтобы ответить.</div>";
else
{
		$link = mysqli_connect("localhost","root","","users");
	$sql = "SELECT * FROM `suspend` WHERE login='{$_SESSION['user']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при запросе: ".mysqli_error($link)) ;
	if ($res)
		if (mysqli_num_rows($res) != 0)
		{
			echo "<br> <br><div style = 'padding: 10px;border: 1px solid black; background-color:rgba(100,100,255,0.4); width: 25%;'>
			Вы не можете отвечать на вопросы, т.к. ваш аккаунт <a href='accMng/banned.php'> заморожен</a>.</div>";
		}
		else
			echo "<form style = 'padding:10px;'method = 'POST' action='access.php'>
				<label> Быстрый ответ </label> <br>
				<textarea style = 'width: 25%; height: 10%;' name = 'text' required> </textarea><br><br>
				 <button name = 'submitRep' value = '{$_GET['t']}'> Отправить </button><br>"; 
}			
	
	 ?>
<br>
<a href='viewforum.php?cat=0'> Назад к вопросам </a>
</div>
</body>
</html>