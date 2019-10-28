<?php
	$firstname = $lastname = $email = $password_1 = $password_2= $password = $gender = $byear = $bmonth = $bday = "";

	$errfirstname = $errlastname = $erremail = $errpassword_1 = $errpassword_2 = $errgender = $errbyear = $errbmonth = $errbday = $errdateofbirth = $errpassword="";
	$counterror = 0;
	$errormsg = $errors = "";
?>
		  <div class="modal fade" id="login-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="signup-form login-form">
				<form method="post" action="<?php echo htmlspecialchars('login.php');?>">
					<div class="login-user-icon"><i class="fas fa-user faa-pulse animated fa-4x"></i></div>

					<h2>User Login</h2>
					<div class="input-item">
						<label>Email <span class="errors blink"> <?php echo $erremail;?></span> </label>
						<input type="text" name="email"/>
					</div>

					<div class="input-item">
						<label>Password <span class="errors blink"> <?php echo $errpassword; ?></span></label>
						<input type="password" name="password"/>

						<span class="errors blink"> <?php echo $errors; ?>
					</div>

					<div class="input-item,">
						<button type="submit" name="user_login">Login</button>
					</div>

					<p>Not yet a member? <a href="signup.php">Create an Account</a></p>

				</form>
			</div>
		 </div> 