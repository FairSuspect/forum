<?php
session_start();
        $link = mysqli_connect ("localhost","root","","users");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }
	   else echo "Successful connect</br>";
$res= mysqli_query($link,"SELECT NOW()") or die("Ошибка ".mysqli_error($link));
$row = mysqli_fetch_row($res);
$time = $row[0];
$sql = "SELECT login, pass, salt, id FROM `users`";
$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link)); 
$banlist = mysqli_query($link,"SELECT * FROM `suspend`") or die("Ошибка " . mysqli_error($link));
$isBanned = 0;
if($result && $banlist)	
{
    $rows = mysqli_num_rows($banlist);
	for ($i = 0 ; $i < $rows ; ++$i)
    {
		$row = mysqli_fetch_row($banlist);
		if($_POST['login'] == $row[0])
		{
			echo $row[1]." : ",$time;
			if($row[1] > $time)
			{
				$isBanned = 1;
				$_SESSION['banMes'] = "{$_POST['login']}, Ваш аккаунт был временно заморожен администатором
				<b style = 'color:red'> {$row[3]}</b>.<br> Причина: {$row[2]}.<br>  Дата разблокировки: {$row[1]}.";
				break;
			}
		}
	}
	$rows = mysqli_num_rows($result); // количество полученных строк
	echo $rows, "</br>";
    //echo "<table><tr><th>Id</th><th>Логин</th><th>Пароль</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
		
		echo "<div style = 'background-color: gray;'> _ </div>";
        $row = mysqli_fetch_row($result);
        $pas = md5(md5($_POST['password']).$row[2]);			
		echo "<div style = 'text-align: center; font-size: 20pt; color: gray;' > {$row[0]} </div>";
			if (strcasecmp($pas, $row[1]) == 0 && $_POST['login'] === $row[0])
			{
				
				
					
						echo "<div style = 'text-align: center; font-size: 30pt; color: green;'> Successful login </br></div>";	
						$_SESSION['user'] = $_POST['login'];
						$lvl = mysqli_query($link, "SELECT `lvl` FROM `users` WHERE `users`.`login` = '{$_POST['login']}' ") or die("Ошибка " . mysqli_error($link)); 
						$row = mysqli_fetch_row($lvl);
						$_SESSION['lvl'] = $row[0];
						
						echo "Lvl is " ,$_SESSION['lvl'];
						echo "</br> USer is " ,$_SESSION['user'];
						// die("</br>Всё ок ");
					
			}
			else if ($_POST['login'] != $row[0])
					echo "login is wrong:  {$_POST['login']} !=  {$row[0]}  </br></br> </br> ";
					else if(strcasecmp($pas, $row[1]) != 0)
						echo "Pass is wrong,  because <div style = 'background-color: red;width: 250px;'> {$pas}  </div> <div style = 'background-color: green; width: 250px;'> != {$row[1]} </div></br>";
    }
    
	    mysqli_free_result($result);
}
if ($isBanned == 1)
				{
					header("Location: banned.php");
					die("На это странице больше делать нечего.");
				}
 header("Location: ../old.php");
?>
<a class="nav" href="../old.php"> Old main page </a>