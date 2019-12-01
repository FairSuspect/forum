<?php
session_start()
?>
<html>

<head>
<title> <?php echo "(",$_SESSION['score'],") "  ; ?>Что больше? </title>
<link rel=stylesheet href="../css/wr.css">

</head>

<body>
<center><h1 > Что больше? </h1></center>
<?php

$first = random_int(2,51);
$second = random_int(2,51);
$third = random_int(51,101);
$fourth = random_int(51,101);
$_SESSION['left'] = $first / $third;
$_SESSION['right'] = $second / $fourth;
echo "<num >", $first ,"</num>";

echo "<num class = 'num1'>", $second," </num> <br />";
?>
<num class = "dash"> — </num> 
<?php echo "<num class = 'text'>ИЛИ  </num>";
?> 
<num class = "dash1"> — </num> <br />
<?php
echo "<num>", $third ,"</num> ";
echo "<num class = 'num1'>", $fourth," </num><br />";
?>

<form action="wrFunc.php" method = "POST">
<input type = "submit" name= "submitLeft" value = "Левое">
<input type = "submit" class = "sec" name = "submitRight" value = "Правое"> <br />
</form>
<?php 
echo "<num> Счёт: ", $_SESSION['score'],"<br />";
?>
<form action='wr.php' method='post'>
<input type = "submit" name = "leaders" value = "Список лидеров">
</form>
<?php
	if(isset($_POST['leaders']))
	{
		/////////////////////////////////////////////////////////////////echo "<script>alert('Работает');</script>";
		$link = mysqli_connect ("localhost","root","","users");
		$sql = "SELECT name, score FROM `LeaderBoard` ORDER BY score DESC";
		$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));		
		$rows = mysqli_num_rows($result);
		echo "<table  style = 'width: 20%; text-align: center; position: fixed; top: 40%; right: 5%; font-family: Impact; font-size: 30pt; color: #bbbbbb;'>";
		echo "<tr>
				<th> Name   </th>
				<th> Score </th>
				</tr>";
		for ($i = 0; $i < 5; ++$i)
		{ 
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			for ($j = 0; $j < 2; ++$j)
				echo "<td> {$row[$j]} </td>";
			echo "</tr>";
		}
		unset($_POST['leaders']);
	}
?>
<a href="../index.php"> Главная страница </a>

</body>

</html>