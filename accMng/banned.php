<html>
<head>
<meta charset = 'utf-8'>
<title> Ваш аккаунт заморожен </title>
</head>
<body>
<center style = 'padding: 15px; border:3px solid black;width: 28%;margin:auto; border-radius: 25px; font-size: 20pt;'>
<?php
session_start();
if(isset($_SESSION['user']))
{
	$link = mysqli_connect("localhost","Kirill","q123123q","kirill_forum");
	$sql = "SELECT * FROM `suspend` WHERE login='{$_SESSION['user']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при запросе: ".mysqli_error($link)) ;
	if ($res)
		if (mysqli_num_rows($res) != 0)
		{
		$row = mysqli_fetch_row($res);
		 echo "{$row[0]}, Ваш аккаунт был временно <b>заморожен</b> администатором <b style='color:red;'>{$row[3]}</b>.<br>
		Причина: <i>{$row[2]}</i>.<br>
		Дата разблокировки: {$row[1]}.";
		}
		else
			echo "Something <br>";
	else 
		echo "!fff <br>";

echo "<br> <a href = '../old.php'> Ясно, на главную </a>";
if(isset($_SESSION['dir']))
	echo "<br> <a href = {$_SESSION['dir']}> Назад </a>";
}
else Header("Location: ../old.php")
?>
</center>
</body>


</html>