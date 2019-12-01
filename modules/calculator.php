<html>

<head>
<link rel=stylesheet href = "css\calculator.css">
<title> Калькулятор </title>

</head>
<body>
<center><h3>Добро пожаловать в калькулятор! </h3> 


<form action= "calculator.php" method ="POST">
	<input name="fN" type="number" />
	<select name="orientation" method = "POST">
		<option value ='+'> + </option>
		<option value ='-'> - </option>
		<option value ='*'> * </option>
		<option value ='/'> / </option>
		</select>
	<input name="sN" type="number" />
	<input name="plus" type="submit" />
</form>
	<?php
/*	
	if(isset($_POST['plus']))
	{
	echo "<result>", $_POST['fN'] + $_POST['sN'],"</result><br />";
	}
*/
if(isset($_POST['plus']))
{
	switch ($_POST["orientation"])
	{
		case '+':
			echo  "<result>",$_POST['fN'] + $_POST['sN'], "</result> <br />";
			break;
		case '-':
			echo  "<result>",$_POST['fN'] - $_POST['sN'], "</result> <br />";
			break;
		case '*':
			echo  "<result>",$_POST['fN'] * $_POST['sN'], "</result> <br />";
			break;
		case '/':
			echo  "<result>",$_POST['fN'] / $_POST['sN'], "</result> <br />";
			break;	
		default: 
		echo "<result>???</result>";
	}
}
	echo $_POST['orientation'];
	
	?>
	
	</center>
	<center><p class="navigation"><a href = '../index.php'> Главная страница </a></p></center>
	</body>
	</html>