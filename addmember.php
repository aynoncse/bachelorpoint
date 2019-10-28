<?php include_once 'inc/header.php'?>
<div class = "container-fluid">
	<div class = "row">
		<?php include_once 'inc/sidebar.php'?>

			
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class = "content">
<?php include_once 'inc/messmenu.php'?>				

		<?php
			if(isset($_POST['addmember'])&& isset($_POST['uid'])){
				$member 	= $_POST['uid'];
				$adminid = $_SESSION['userID'];
				$count	= sizeof($member);
			
				$query = "SELECT * FROM user WHERE id=$adminid";
				$result = $db->selectData($query);
				if ($result) {
					$userData = mysqli_fetch_array($result);
					$messID   = $userData['m_id'];

					for ($i=0; $i <$count; $i++) { 
						$query = "UPDATE user SET m_id = '$messID' WHERE id = '$member[$i]'";
						$result = $db->updateData($query);
					}
					
						echo "<div class='success'>Added Successfully..</div>";					
				}else {
					echo "<div class='errors blink'>Failed..!</div>";
				}
			}


		?>	
				<div class="createmess">
					<h2>Add Member</h2>
					<form action="" method="post">
						<div class="createmess-item">
			<?php 
			for ($i=1; $i <= 7; $i++) { 
				echo '<p>'.$i.'</p>';
		?>		
							<select name='uid[]'>
								<option disabled selected value>Select Member</option>
		<?php 
			$query 	= "SELECT * FROM user WHERE m_id = '0' ORDER BY id DESC";
			$result 	= $db->selectData($query);
			if ($result) {
				while ($user = $result->fetch_assoc()) {
					echo $user['firstname'];
		?>
								<option value="<?php echo $user['id'];?>"><?php echo $user['email'];?></option>
		<?php } } ?>
							</select>
		<?php } ?>
						</div>
						<button type="submit" value="Submit" name="addmember">ADD</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once 'inc/footer.php'?>
							
						
							