<?php
        $link = mysqli_connect ("localhost","root","","users");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }
	   else echo "Successful </br>";
$salt = mt_rand(100, 999);
$tm = time();
$_POST['password'] = md5(md5($_POST['password']).$salt);
$regdata = "INSERT INTO `users` (`login`, `pass`,`salt`) VALUES ( '{$_POST['login'] }','  {$_POST['password']}',' {$salt} ');";
$register = mysqli_query($link, $regdata);
if (!$register)
{
	echo "Error :( </br>";
	echo $regdata;
}
else
	{
		
}



?>