<?php session_start() ;
$link = mysqli_connect ("localhost","root","","users");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }?>
<html>
    <head>
	<meta charset="utf-8">
	<link rel = stylesheet href = "..\css\main.css">
    <title>Управление аккаунтами</title>
	
    </head>
<body>
<h1 align = 'middle'> Управление аккаунтами </h1>
<table align = 'center' style ='text-align: center;' width = '500px' border= '1px solid'>
<th> id </th>
<th> login </th>
<th> Date of registration </th>
<th> lvl </th>
<th> Action </th>
<?php
	$sql = "SELECT id, login, regDate, lvl FROM users";
	$result = mysqli_query($link,$sql);
	if($result)
	{
		$rows = mysqli_num_rows($result);
		for($i = 0; $i < $rows; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			for ($j = 0; $j < 4; $j++)
			{
				echo "<td> {$row[$j]} </td>";
			}
			if ($row[3] < $_SESSION['lvl'])
			{
				echo "<td> <form action = 'action.php' method = 'POST'>
						<button name = 'delete' value = '{$row[0]}' style = 'color:white; background-color: red'> X </button>";
				
				if(isset($_POST['suspend']))
				{
					if($_POST['suspend'] == $row[1])
						echo "<form action = 'action.php' method = 'POST'>
								<select  style = 'color:white; background-color: red' name = 'time'> 								
								<option value = '10000'> 1 hour </option>
								<option value = '1000000'> 1 day </option>
								<option value = '7000000'> 1 week </option>
								<option value = '100000000'> 1 month </option>
								<option value = '10000000000'> 1 year </option>
							</select>
							<input type = 'text' name = 'reason'>
							<button value = '{$_POST['suspend']}' name='confirm'></button>✓</input> </form>";
					
				}
			if ($row[3] != 1 && $_SESSION['lvl']> 1)
				echo "<button action = 'manage.php' name = 'upgrade' value = '{$row[0]}' style = 'color:white; background-color: green'> + </button></form>";
			elseif ($row[3] == 1 && $_SESSION['lvl']>1)
				echo "<button action = 'manage.php' name = 'downgrade' value = '{$row[0]}' style = 'color:white; background-color: red'> - </button></form>";
			echo "</form>";
			echo " <button name = 'suspend' value = '{$row[1]}' style = 'color:white; background-color: red'> Ban </button></td>";
			}
			else echo "<td> </td>";
			echo "</tr>";
		}
	}

?>
</table>
<nav> <a href='../old.php'> Old </a>  |  |  <a href='../index.php'> Main </a>
<?php /*
if(isset($_POST['delete']))
{
	     
	$sql = "DELETE FROM `users` WHERE `users`.`id` = '{$_POST['delete']}' ";
	$result = mysqli_query($link,$sql) or dir("Ошибка: ".mysqli_error($link));
	header("Location: manage.php");
}
if(isset($_POST['upgrade']))
{
	     
	$sql = "UPDATE `users` SET `lvl`= '1' WHERE `users`.`id` = '{$_POST['upgrade']}' ";
	$result = mysqli_query($link,$sql) or dir("Ошибка: ".mysqli_error($link));
	header("Location: manage.php");
}
if(isset($_POST['downgrade']))
{
	     
	$sql = "UPDATE `users` SET `lvl`= '0' WHERE `users`.`id` = '{$_POST['downgrade']}' ";
	$result = mysqli_query($link,$sql) or dir("Ошибка: ".mysqli_error($link));
	header("Location: manage.php");
}
*/?>
</body>
</html>