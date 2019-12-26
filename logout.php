<html>
<head>
<title> Logout </title>

</head>
<body background-color = #bbbbbb>

<?php
session_start(); 
unset($_SESSION['user']);
unset($_SESSION['lvl']);
unset($_SESSION['id']);
header("Location: index.php");
exit;
?>


</body>
</html>