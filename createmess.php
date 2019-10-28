<?php include_once 'inc/header.php'?>

<div class = "container-fluid">
	<div class = "row">
		<?php include_once 'inc/sidebar.php'?>

			
		<div class = "col-md-9">
		<div class="col-xs-12 col-sm-12 col-md-12">
		<?php
			if(isset($_POST['createmess'])){
				$messName 	= $fm->validate($_POST['name']);
				$houseno 	= $fm->validate($_POST['houseno']);
				$roadno 	= $fm->validate($_POST['roadno']);
				$area 		= $fm->validate($_POST['area']);
				$city 		= $fm->validate($_POST['city']);
				$creator	= $_SESSION['userID'];

				$query = "SELECT * FROM user WHERE id=$creator";
				$result = $db->selectData($query);
				if ($result) {
					$userData = mysqli_fetch_array($result);
					if ($userData['m_id']==0) {
						$query = "INSERT INTO mess (name, houseno, roadno, area, city, creator) VALUES('$messName', '$houseno', '$roadno', '$area', '$city', '$creator')";
						$createmess = $db->createData($query);
						if ($createmess) {
							$query 	= "SELECT * FROM mess WHERE creator = '$creator'";
							$result = $db->selectData($query);

							if ($result) {
								$result = mysqli_fetch_array($result);
								$creatorID = $result['id'];

								$query = "UPDATE user SET m_id = '$creatorID', role = '1' WHERE id = '$creator'";
								$result = $db->updateData($query);

								if ($result) {
									echo "<span class='success'>Created Successfully..</span>";
								}
							}
						}else {
							echo "<span class='errors blink'>Failed..!</span>";
						}
					}else{
						echo "<span class='errors blink'>Cant Create..! You are already a member of a Mess</span>";
					}
				}
			}


		?>	
				<div class="createmess">
					<h2>Create Mess</h2>		
					<form action="" method="post">
						<div class="createmess-item">
							<input type="text" name="name" placeholder="Give a Name of Your Mess....." required/>
							<input type="text" name="houseno" placeholder="House No..." required/>
							<input type="text" name="roadno" placeholder="Road..." required/>
							<input type="text" name="area" placeholder="Area..." required/>
							<input type="text" name="city" placeholder="City..." required/>
							
							</div>
						<button type="submit" value="Submit" name="createmess">Create</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once 'inc/footer.php'?>



