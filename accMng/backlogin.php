<?php

        $link = mysqli_connect ("localhost","root","","users");
       if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
	   }
	   else echo "Successful connect</br>";
	  $a = 's';
	  $b = 's';
	  if (strcasecmp($a, $b) != 0)
		  echo "А сравнение вообще не работает </br>";
	  else echo "ss";
$sql = "SELECT login, pass, salt FROM `users`";
$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link)); 

if($result)
{
    $rows = mysqli_num_rows($result); // количество полученных строк
     
	 
    //echo "<table><tr><th>Id</th><th>Логин</th><th>Пароль</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
      
        $row = mysqli_fetch_row($result);
        $pas = md5(md5($_POST['password']).$row[2]);
		 echo "<div style= 'background-color: red; width: 50px;' > ", gettype ( $pas ) ,"</div>";
		  echo "<div style= 'background-color: green; width: 50px;' > ", gettype (  $row[1] ), "</div>";
		  if (gettype ( $pas ) != gettype (  $row[1] ))
			  echo "Типы не равны";
		  else echo "ravni </br>";
                $sal = 347;
				echo "pas is ",md5(md5($_POST['password']).$row[2]), " salt is ",$row[2], "</br>";
				echo "test + 347 ",md5(md5('test').'347'), " salt is ",'347', "</br>";
				echo "test + sal ",md5(md5('test').$sal), " salt is ",$sal, "</br>";
				echo " {$pas}";
				echo "</br>", $row[1], "</br>";
			if (strcasecmp($pas, $row[2]) == 0 && $_POST['login'] === $row[0])
				echo "Successful login </br>";
			else if(strcasecmp($pas, $row[2]) != 0)
				echo "Pass is <color >wrong,  because <div style = 'background-color: red;width: 250px;'> {$pas}  </div> <div style = 'background-color: green; width: 250px;'> != {$row[1]} </div></br>";
			else if ($_POST['login'] != $row[0])
					echo "login is wrong:  {$_POST['login']} !=  {$row[0]}  </br></br> </br> ";
			
    }
    echo "</table>";
	    mysqli_free_result($result);
}
 
?>
