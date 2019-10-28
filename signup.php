<?php
    include 'lib/Session.php';
    Session:: checkLogin();
?>
<?php
	include 'config/config.php';
	include 'lib/DB.php';
	include 'helpers/Format.php';
	$db = new DB();
	$fm = new Format();
?>

<?php
$maleavatar = "<img src='img/male.png'/>";
$femaleavatar = "<img src='img/female.png'/>";

?>


<?php
if(isset($_POST['user_signup'])){
	if(empty($_POST['firstname'])){
		$errfirstname = "First Name is required";
		$counterror += 1;
	} else if (!preg_match("/^[a-zA-Z ]*/", $fm->validate($_POST['firstname']))){
		$errfirstname = "Use letters and white space only";
		$counterror += 1;
	}else {
		$firstname = $fm->validate($_POST['firstname']);
	}


	if(empty($_POST['lastname'])){
		$errlastname = "last Name is required";
		$counterror += 1;
	} else if (!preg_match("/^[a-zA-Z ]*/", $fm->validate($_POST['lastname']))){
		$errlastname = "Use letters and white space only";
		$counterror += 1;
	}else {
		$lastname = $fm->validate($_POST['lastname']);
	}

	if(empty($_POST['email'])){
		$erremail = "Email  is required";
		$counterror += 1;
	} elseif (!filter_var($fm->validate($_POST['email']), FILTER_VALIDATE_EMAIL)) {
		$erremail = "Invalid e-mail format";
		$counterror += 1;
	}else {
	$email = $fm->validate($_POST['email']);

	}

	if(empty($_POST['password_1'])){
		$errpassword_1 = "Password is required";
		$counterror += 1;
	} 

	if(empty($_POST['password_2'])){
		$errpassword_2 = "Retype your password";
		$counterror += 1;
	}

	if ($_POST['password_1'] == $_POST['password_2'] ) {
		$password = $fm->validate($_POST['password_1']);
	} else {
		$errpassword = "Two passwords do not match";
		$counterror += 1;
	}

	if (empty($_POST["gender"])) {
	$errgender = "Gender is required";
	$counterror += 1;
	} else {
	$gender = $fm->validate($_POST['gender']);
	}
	if (empty($_POST['byear']) and empty($_POST['bmonth']) and empty($_POST['bday'])) {
		$errdateofbirth = "Date of birth is required";
		$counterror += 1;
	} else {
		$byear 	= $fm->validate($_POST['byear']);
		$bmonth = $fm->validate($_POST['bmonth']);
		$bday 	= $fm->validate($_POST['bday']);
		$dob 	= $byear.':'.$bmonth.':'.$bday;
	}	
	
	
	if($counterror==0){
		$query = "SELECT email FROM user WHERE email = '$email'";
		$results = $db->selectData($query);

		if(!$results){
			$password = md5($password);
			$sql = "INSERT INTO user (firstname, lastname, email, password, gender, dob) VALUES ('$firstname', '$lastname', '$email', '$password', '$gender', '$dob')";
			$inserted = $db->createData($sql);
			if ($inserted) {
				Session::set("login", true);
                Session::set("email", $value['email']);
                Session::set("userID", $db->link->insert_id);
                Session::set("successmsg", 'Thank you for registering! A confirmation email has been sent to ' . $email . ' Please click on the Activation Link to Activate your account');
                header("Location: home.php");
            } else { 
                echo '<div class="errormsgbox">You could not be registered due to a system error. We apologize for any inconvenience.</div>';
            }
		}else {
            $errormsg = '<div class="errormsgbox" >That Email has already been registered.</div>';
        }
	}
}
?>

<!doctype html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fontawesome-all.min.css">
	<link rel="stylesheet" href="css/font-awesome-animation.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
   <style>



</style>
  </head>
  <body>
    <!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
    <!-- Add your site or application content here -->

	<div class="bg-img">
		
	</div>
	
	
	
<div class="bg-img2">
		
	</div>
	
	<div style="top:10px; position:relative; left:0" class="signup-form">
			
		<form method="post" action="<?php echo htmlspecialchars('signup.php');?>">
			<div class="signup-user-icon"><i class="fas fa-users faa-wrench animated fa-4x"></i></div>
			<h2><i class="fas faa-passing animated">Create An account</i></h2>
			<div class="input-item">
				<label>First Name * <span class="errors blink"> <?php echo $errfirstname; ?></span></label> 
				<input type="text" name="firstname" value="<?php echo $firstname; ?>"/>
			</div>

			<div class="input-item">
				<label>Last Name * <span class="errors blink"> <?php echo $errlastname; ?></span></label>
				<input type="text" name="lastname" value="<?php echo $lastname; ?>"/>
			</div>

			<div class="input-item">
				<label>Email * <span class="errors blink"> <?php echo $erremail . $errormsg; ?></span></label>
				<input type="email" name="email" value="<?php echo $email?>"/>
			</div>

			<div class="input-item">
				<label>Password  * <span class="errors blink"> <?php echo $errpassword_1; ?></span></label>
				<input style="float: left;" type="password" id="psw" name="password_1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>

				<div class="pw-btn" type="button" onclick="myFunction()">
				    <i id="pw-eye" class="fa fa-fw fa-eye"></i>
				</div>
			</div>

			<div class="input-item">
				<label>Confirm Password * <span class="errors blink"> <?php echo $errpassword_2; ?></span></label>
				<input style="float: left;" type="password" name="password_2" id="psw2" required/>

				<div class="pw-btn" type="button" onclick="myFunction2()">
				    <i id="pw-eye2" class="fa fa-fw fa-eye"></i>
				</div>
				
				<span class="errors blink"><?php echo $errpassword; ?></span>
			</div>
			
			<div class="input-item diff-item">
				<label>Gender * <span class="errors blink"> <?php echo $errgender; ?></span></label>
				<input type="radio" name="gender" value="Male" />Male
				<input type="radio" name="gender" value="Female"/>Female
			</div>

			<div class="input-item diff-item">
				<label id="diff-label">Date of Birth * <span class="errors blink"><?php echo $errdateofbirth ."<br/>"; ?></span></label>
				<?php
					echo '<select name="byear" >';
					  echo '<option>Year</option>';
						for($i = (date('Y')-13); $i >= date('Y', strtotime('-100 years')); $i--){
						  echo "<option value='$i'>$i</option>";
						} 
					echo '</select>';
					echo '<select name="bmonth" >';
						echo '<option>Month</option>';
						for($i = 1; $i <= 12; $i++){
						  $i = str_pad($i, 2, 0, STR_PAD_LEFT);
							echo "<option value='$i'>$i</option>";
						}
					echo '</select>';
					echo '<select name="bday" >';
					  echo '<option>Day</option>';
						for($i = 1; $i <= 31; $i++){
						  $i = str_pad($i, 2, 0, STR_PAD_LEFT);
							echo "<option value='$i'>$i</option>";
						}
				echo '</select>';
				
				?>
			</div>
			
			<!--Display validation error here-->
			<div class="input-item">
				<button type="submit" name="user_signup" style="color:FFFF9C;" >Sign up</button>
			</div>
				
			<p>
				Already a member? <a href="login.php">Login</a>
			</p>
		</form>	
	</div>
	<div id="message">
	  <h3>Password must contain the following:</h3>
	  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
	  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
	  <p id="number" class="invalid">A <b>number</b></p>
	  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
	</div>

	
	
	
	
	
	<script>
		function myFunction() {
    var x = document.getElementById("psw");
    if (x.type === "password") {
    	document.getElementById("pw-eye").className = "fa fa-fw fa-eye-slash";
        x.type = "text";
    } else {
        x.type = "password";
        document.getElementById("pw-eye").className = "fa fa-fw fa-eye";
    }
}

	function myFunction2() {
    var x = document.getElementById("psw2");
    if (x.type === "password") {
    	document.getElementById("pw-eye2").className = "fa fa-fw fa-eye-slash";
        x.type = "text";
    } else {
        x.type = "password";
        document.getElementById("pw-eye2").className = "fa fa-fw fa-eye";
    }
}

var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
    <script src="js/vendor/modernizr-3.5.0.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous">
    </script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/plugins.js">
    </script>
    <script src="js/main.js">
    </script>
    

    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer>
    </script>
  </body>
</html>
