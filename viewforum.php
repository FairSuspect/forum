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
	<meta name='viewport'	 content=' width=device-width, user-scalable = yes'>
	<link rel = stylesheet href = "..\css\viewforum.css">
	<title> Вопросы </title>
<head>
<body>
<div class='quests'>
<center><h1> Задай свой вопрос! </h1> </center> 
<form method = 'GET' action = 'viewforum.php'>
	<label> Выбери теги для поиска </label>
	<input type='checkbox' name='C++' value = '0b1'> C++ </input>
	<input type='checkbox' name='C' value = '0b10'> C</input>
	<input type='checkbox' name='C#' value = '0b100'> C# </input>
	<input type='checkbox' name='php' value = '0b1000'> php </input>
	<input type='checkbox' name='web' value = '0b10000'> web </input>
	<input type='checkbox' name='java' value = '0b100000'> java </input>
	<input type='submit' value = 'Подтвердить' name = 'confirm'> </input>
</form>
<!---<div class= 'quests'> --->
<?php if (empty($_SESSION['user'])) 
	echo "<div style = 'height: 25px;position: relative; left: 63%; padding: 10px;border: 1px solid black; background-color:rgba(100,100,255,0.4); width: 30%;'>
<a href='old.php'> Войдите</a> или <a href = '/accMng/registration.php'> зарегистрируйтесь</a>, чтобы ответить.</div>";
else 
	{
		$link = mysqli_connect("localhost","root","","users");
		$sql = "SELECT * FROM `suspend` WHERE login='{$_SESSION['user']}'";
		$res = mysqli_query($link,$sql) or die("Ошибка при запросе: ".mysqli_error($link)) ;
		if ($res)
			if (mysqli_num_rows($res) != 0)
			{
				echo "<br> <br><div align = 'right' style = 'padding: 10px;border: 1px solid black; background-color:rgba(100,100,255,0.4); width: 35%; font-size: 14px;'>
				Вы не можете задавать вопросы, так как ваш аккаунт <a href='accMng/banned.php'> заморожен</a>.</div>";
			}
			else 
				echo "<div align = 'right' style='padding: 10px;  width: 97%;'> <form action='create.php'> <button style = 'width=10px;' name='create' > Задать вопрос </button> </form></div>"; 
	}

		
	
?>

<table border='1px' class='quests'>
	
	<th width='60%'> Вопросы / Автор</th>
	<th> Ответов </th>
	<th> Просмотров </th>
	<th> Последнее сообщение </th>
	
<?php 
$sql = "SELECT * FROM `topics` WHERE `category` = '0' ORDER BY `lastRepDate` DESC";
$res = mysqli_query($link,$sql) or die("Ошибка: ".mysqli_error($link));
if($res)
{	
	$rows = mysqli_num_rows($res);
	for($i = 0; $i < $rows; $i++)
	{
		echo "<tr>";
		$row = mysqli_fetch_row($res);
		$cat = $row[5]; // id категории
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
		echo "<td> <a class='question' href='viewtopic.php?cat={$cat}&t={$row[0]}'>".$row[2]."</a><br><i style='font-size: 14px;'> Вопрос задал: </i><a  style='font-size: 14px; color: #{$color};' href='viewprofile.php?u={$id[0]}'>    {$row[1]}</a></td>";
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
		echo "<td align='center'>{$replies}</td><td align='center'>{$row[8]}</td><td align='center'><a href = 'viewprofile.php?u={$id[0]}' style='font-size: 14px; color: #{$color};' >{$row[6]}</a><br>{$row[7]}</td></tr>";
		//die("row6 and 7: ".$row[6]." / ".$row[7]);
	}
	
}


?>

<?php
function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }
	
if(isset($_GET['confirm']))
{
	$tags = decbin($_GET['C++']+$_GET['C']+$_GET['C#']+$_GET['php']+$_GET['web']+$_GET['java']);
	//echo 
}
if(isset($_GET['confirm']))
	{
		$res=0;
		if(isset($_GET['C++']))
$res += IsChecked('C++','0b1') ? 0b1 : 0;
$res += IsChecked('C','0b10') ? 0b10 : 0;
$res += IsChecked('C#','0b100') ? 0b100 : 0;
$res += IsChecked('php','0b1000') ? 0b1000 : 0;
$res += IsChecked('web','0b10000') ? 0b10000 : 0;
$res += IsChecked('java','0b100000') ? 0b100000 : 0;
echo "<br>";
echo $res;
	}
?>
<a href='old.php'> Назад на главную </a>
</div>
</body>
</html>