<?php session_start() ;
$link = mysqli_connect ("localhost","kirill","q123123q","kirill_forum");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }?>
<html>
    <head>
	<meta charset="utf-8">
	<link rel = stylesheet href = "css\viewforum.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <title>Список пользователей</title>
	
    </head>
<body>
<div class='quests'>
<header>
<a class = 'headerLink' style = 'text-decoration: none:' href = 'index.php'>
	<h1> ProgPeak Forum</h1> 
</a>
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

		
	
?>
<h1 align = 'middle'> Список пользователей </h1>
<table align = 'center' style ='text-align: center;' width = '500px' border= '1px solid'>
<th> id </th>
<th> login </th>
<th> Date of registration </th>
<th> lvl </th>
<th> Action </th>
<?php
if(isset($_GET['l']))
	$sql = "SELECT id, login, regDate, lvl FROM users WHERE `lvl` = '{$_GET['l']}'";
else 
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
				if($j == 1)
				{
					switch($row[3]){
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
					echo "<td> <a style = 'color: #{$color}' href='viewprofile.php?u={$row[0]}'> {$row[1]} </a></td>";
					continue;
				}
				echo "<td> {$row[$j]} </td>";
			}
			if(isset($_SESSION['lvl']))
			{
				if ($row[3] < $_SESSION['lvl'])
				{
					echo "<td> <form action = 'accMng/action.php' method = 'POST'>
							<button class = 'dwn' name = 'delete' value = '{$row[0]}' > X </button>";
					
					if(isset($_POST['suspend']))
					{
						if($_POST['suspend'] == $row[1])
							echo "<form action = 'accMng/action.php' method = 'POST'>
									<select  style = 'color:white; background-color: red' name = 'time'> 								
									<option value = '10000'> 1 hour </option>
									<option value = '1000000'> 1 day </option>
									<option value = '7000000'> 1 week </option>
									<option value = '100000000'> 1 month </option>
									<option value = '10000000000'> 1 year </option>
								</select>
								Причина: <input type = 'text' name = 'reason'>
								<button value = '{$_POST['suspend']}' name='confirm'>✓</button></input> </form>";
						
					}
					if ($row[3] != 1 && $_SESSION['lvl']> 1)
						echo "<button class='upd' action = 'accMng/action.php' name = 'upgrade' value = '{$row[0]}'> + </button></form>";
					elseif ($row[3] == 1 && $_SESSION['lvl']>1)
						echo "<button class='dwn' action = 'accMng/action.php' name = 'downgrade' value = '{$row[0]}'> - </button></form>";
					echo "</form>";
					echo " <form action = 'memberlist.php?p=0' method = 'POST'><button  class='dwn' name = 'suspend' value = '{$row[1]}' > Ban </button></form></td>";
				}
				else 
				echo "<td> </td>";
			}
			else 
				echo "<td> </td>";
			echo "</tr>";
		}
	}

?>
</table>
<nav style='text-align:center'> <a href='../index.php'> Main </a> </nav>
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
</div>
</body>
</html>