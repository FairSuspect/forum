{
        echo "Регистрирую..<br>";
        $sql = "SELECT `id` FROM `users` WHERE `login`='{$_POST['login']}'";
        $res = mysqli_query($link,$sql) or die("Ошибка при загрузке логина: ".mysqli_error($link));
        if($res)
        {       

                $id = mysqli_fetch_row($res);
                $key = md5(md5($_POST['login']).$salt);
                $sql = "INSERT INTO `waiting` (`id`,`login`,`e-mail`,`e-key`,`salt`) VALUES ( '{$id[0]}','{$_POST['login']}','{$_POST['e-mail']}','{$key}','{$salt}')";
                $add = mysqli_query($link,$sql);
                echo "Зарегистрировал, пытаемся сделать письмо..<br>";
                if($add)
                {
                        echo "<fieldset><legend> Имитация электронного письма </legend>";
                        $message = "Здравствуйте, ваша почта была введена при регистрации на форуме ###.
                        Для подтверждения электронной почты, пройдите по этой <a href='action.php?u={$id[0]}&key={$key}'>ссылке</a>.
                        Если вы нигде не регистрировались, то просто проигнорируйте это письмо.</filedset>";
                        $subject = "Подтвердите регистрацию на ###";
                        echo $subject;
                        echo "<br>";
                        echo $message;
                        //mail();
                }
                else die("Ошибка при 'создании сообщения': ".mysqli_error($link));
		
        }
               
}