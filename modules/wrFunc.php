<?php
session_start();	
$flag = False;
if(empty($_SESSION['score']))
	echo "no score </br>";
else
	echo $_SESSION['score'];
$link = mysqli_connect ("localhost","root","","users");
if(isset($_POST['submitLeft']))
{
	if ($_SESSION['left'] - $_SESSION['right']> 0)
	{
		$_SESSION['score']++;
		header('Location: wr.php');
	}
	else if ($_SESSION['left'] - $_SESSION['right']< 0)
	{
		$sql = "SELECT name FROM `LeaderBoard` ORDER BY score";
		$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));		
		$rows = mysqli_num_rows($result);
		echo "</br> Entering for </br>";
		if ($rows == 0)
		{
			$regdata = "INSERT INTO `LeaderBoard` (`name`, `score`) VALUES ( '{$_SESSION['user']}','{$_SESSION['score']}');";
			$register = mysqli_query($link, $regdata) or die("Ошибка " . mysqli_error($link)); 
			echo "+guy";
		}
		for($i = 0; $i < $rows and !$Flag; $i++)
		{ 
			echo "i was here";
			$row = mysqli_fetch_row($result);
			if ($row[0] == $_SESSION['user'])				
				$Flag = True;
		}
			if ($Flag)
			{				
				$req = "UPDATE `LeaderBoard` SET `score` =' {$_SESSION['score']} ' WHERE `LeaderBoard`.`name` = ' {$row[0]} ' ;";
				mysqli_query($link, $req);						
			}
			
			else if (!empty($_SESSION['user']))
			{
				$regdata = "INSERT INTO `LeaderBoard` (`name`, `score`) VALUES ( '{$_SESSION['user']}','{$_SESSION['score']}');";
				$register = mysqli_query($link, $regdata) or die("Ошибка " . mysqli_error($link)); 
				echo "+guy";
			}
		
		$_SESSION['score'] = 0;
		echo $_SESSION['score'];
		header('Location: wr.php');
	}
}

if(isset($_POST['submitRight']))
{
	if ($_SESSION['right'] - $_SESSION['left'] > 0)
	{
		$_SESSION['score']++;
	header('Location: wr.php');
	}
	else if ($_SESSION['right'] - $_SESSION['left'] < 0)
	{
		echo "<script>alert('Работает');</script>";
		$sql = "SELECT name FROM `LeaderBoard` ORDER BY score";
		$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));		
		$rows = mysqli_num_rows($result);
		echo "</br> Entering for </br>";
		if ($rows == 0 )
		{
			$regdata = "INSERT INTO `LeaderBoard` (`name`, `score`) VALUES ( '{$_SESSION['user']}','{$_SESSION['score']}');";
			$register = mysqli_query($link, $regdata) or die("Ошибка " . mysqli_error($link)); 
			echo "+guy";
		}
		for($i = 0; $i < $rows; $i++)
		{ 
			echo "<script>alert('Работает');</script>";
			echo "i was here";
			$row = mysqli_fetch_row($result);
			if ($row[0] == $_SESSION['user'])
			{				
				$Flag = True;
				echo "<script>alert('Работает');</script>";
				break;
			}
		}
			if ($Flag == True)
			{	
				echo "<script>alert('Работает');</script>";		
				$req = "UPDATE `LeaderBoard` SET `score` =' {$_SESSION['score']} ' WHERE `LeaderBoard`.`name` = ' {$row[0]} ' ;";
				mysqli_query($link, $req);						
			}
			
			else if (!empty($_SESSION['user']))
			{
				$regdata = "INSERT INTO `LeaderBoard` (`name`, `score`) VALUES ( '{$_SESSION['user']}','{$_SESSION['score']}');";
				$register = mysqli_query($link, $regdata) or die("Ошибка " . mysqli_error($link)); 
				echo "+guy";
			}
		
		$_SESSION['score'] = 0;
		echo $_SESSION['score'];
		header('Location: wr.php');
	}
}
header('Location: wr.php');

?>