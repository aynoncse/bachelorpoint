<?php include_once 'inc/header.php'?>
<?php
	$userID = $_SESSION['userID'];
	$query = "SELECT * FROM user WHERE id='$userID'";
		$result = $db->selectData($query);
		if ($result) {
			$userData = mysqli_fetch_array($result);
			if ($userData['role']!=1) {
				header("Location: mymess.php");
			}
		}
?>
<div class = "container-fluid">
	<div class = "row">
		<?php include_once 'inc/sidebar.php'?>

			
		<div class="col-xs-12 col-sm-12 col-md-12"">
			<div class = "content">
<?php include_once 'inc/messmenu.php'?>				
		
				<div class="createmess">
					<h2>Set Role</h2>	
						<div class="createmess-item">
		<?php
			if(isset($_POST['setrole'])){
				if (!isset($_POST['m_member'])) {
					echo "<div class = 'errors blink'>Please Select a Member </div>";
				}elseif (!isset($_POST['role'])) {
					echo "<div class = 'errors blink'>Please Select a Role </div>";
				}else{
					$member 	= $_POST['m_member'];
					$role 		= $_POST['role'];
					$countM		= sizeof($member);
					$countR		= sizeof($role);
					
					if ($countR != $countM) {
						echo "<div class = 'errors blink'>Please Select Both Member and Role </div>";		
					}else {
						for ($i=0; $i <$countR ; $i++) {
							$query = "UPDATE user SET role = '$role[$i]' WHERE id = '$member[$i]'";
							$result = $db->updateData($query);
						}
						if ($result) {
								echo "<div class = 'success'>Success!!</div>";
							}
					}			
				}	
			}
		?>
							<form action="" method="post">
		<?php 
			$query = "SELECT * FROM user WHERE id='$userID'";
			$result = $db->selectData($query);
				if ($result) {
					$userData = mysqli_fetch_array($result);
					$messID   = $userData['m_id'];
				}

			$query 	= "SELECT * FROM user WHERE m_id = '$messID' ORDER BY id DESC";
			$result 	= $db->selectData($query);
			if ($result) {
				while ($user = $result->fetch_assoc()) {
		?>
								<div class="chkitem"><span class="chkitem-name"><input type="checkbox" name="m_member[]" value="<?php echo $user['id'];?>"> <?php echo $user['firstname'];?></span>
								<select name="role[]" style="width: 35%; float: left; margin: 0 0 15px 0; padding: 0">
									<option disabled selected value>Select Role</option>
									<option value="1">Director</option>
									<option value="2">Manager</option>
									<option value="0">Member</option>
								</select>
								</div>
		<?php  } ?>
		<?php } ?>
						</div>
						<button type="submit" value="Submit" name="setrole">SET</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once 'inc/footer.php'?>
							
						
							