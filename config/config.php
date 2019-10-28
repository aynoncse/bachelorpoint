<?php
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'bachelorpoint');
	define('TITLE', 'Bachelor Point');
?>

<?php
	$firstname = $lastname = $email = $password_1 = $password_2= $password = $gender = $byear = $bmonth = $bday = "";

	$errfirstname = $errlastname = $erremail = $errpassword_1 = $errpassword_2 = $errgender = $errbyear = $errbmonth = $errbday = $errdateofbirth = $errpassword="";
	$counterror = 0;
	$errormsg = $errors = "";
?>