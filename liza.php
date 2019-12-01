<!DOCTYPE html>
<html>
<head>
<title> Main </title>
<meta charset='utf-8'>
<link href='css/liza.css' rel= 'stylesheet'>
</head>
<body>
<h1 style='color: red; font-size:50;'>I'm </h1><br>
<?php
session_start();
if(isset($_SESSION['user']))
{
	$link = mysqli_connect("localhost","root","","users");
	$sql = "SELECT * FROM `suspend` WHERE login='{$_SESSION['user']}'";
	$res = mysqli_query($link,$sql) or die("Ошибка при запросе: ".mysqli_error($link)) ;
	if ($res)
		if (mysqli_num_rows($res) == 0)
		{
			echo "Nothing <br>";
		}
		else
			echo "Something <br>";
	else 
		echo "!fff <br>";
	
	
}
$bin= 0b1+0b10;
echo decbin($bin);
echo "<hr>";
$bin1=0b10;
$bin2= 0b1;
$bin = decbin($bin1 + $bin2);
echo $bin;
echo "<hr>";
$name = 'Katya';
$age = 232;
if(isset($age) && isset($name)) 
	echo "I'm ".$name." and I'm {$age} years old.";
$text =  <<<EOT
Меня зовут "$name". Я печатаю
Теперь я вывожу 
Это должно вывести заглавную букву 'A': \x41
EOT;
echo "<i>".$text."</i>";
?>
<div class= 'class'>
<form action = 'liza.php' method = 'POST'>
	<label> Имя </label>
	<input type='text' name = 'name'>
	<label> Возраст </label>
	<input type = 'number' name='age'>
	<input type = 'submit' name='ok' value = 'Отправить'>
	<button name = 'ok1'> Отправить </button>
</form>
</div>	
<table>
<tr>
<td> ыы </td>
<td> dfd </td>
</tr>
<tr> 
<td> df </td>
<td> dfs </td>
</tr>
</table>

<img style = 'width: 10%;'src='/img/maxresdefault.jpg'>
<?php
if(isset($_POST['ok1']))
{
	echo "<br> Hello, I'm {$_POST['name']} and I'm {$_POST['age']} old.";
}
$link = mysqli_connect("localhost","root","","users") or die("Ошибка. ".mysqli_error($link));
$sql = "SELECT * FROM `users`";
$res = mysqli_query($link,$sql);
if($res)
{
	$rows = mysqli_num_rows($res);
	echo "<br>".$rows;
	for($i = 0; $i < $rows; $i++)
	{
		$row = mysqli_fetch_row($res);
		echo "<br> {$row[0]} | {$row[1]} | {$row[2]}";
	}
}
$color = 0xF;

$color = '11F';
echo "<div style='color: #{$color}'>". $color."</div>";
$color = 0x1F0;
echo "<div style='color: #{$color}'>". $color."</div>";
$color = 0xFF0000;
echo "<div style='color: #{$color}'>". $color."</div>";
$color = 0x000;
echo "<div style='color: #{$color}'>". $color."</div>";
?>

<div style='color: #900'> Текст должен быть красным </div>
<br>
<br>
<div style = 'text-align: center; margin: 10px; border: 5px solid red; width:50%; padding: 10px'>
Текст
<form action = 'liza.php' method = 'POST'>
	<label> Имя </label>
	<input style = 'width:50px; type='text' name = 'name'>
</div>
</body>


</html>