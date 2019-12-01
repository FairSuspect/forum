<?php session_start() ?>
<html>
<head>
<meta charset='utf-8'>
<title> Создание вопроса </title>
</head>
<body>
<form style = 'padding:10px;'method = 'POST' action='access.php'>
	<label> Заголовок вопроса </label> <br>
	<input type='text' name = 'title' required> <br><br>
	<label> Текст вопроса </label> <br>
	<textarea style = 'width: 25%; height: 10%;' name = 'text' required> </textarea><br><br>
	<input type='submit' name = 'submit'> Отправить </input><br>



</body>

</html>