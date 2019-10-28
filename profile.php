<?php include_once 'inc/header.php'?>
<?php include_once 'inc/sidebar.php'?>
<?php include_once 'uploadimage.php'?>
<div class = "container-fluid">
	<div class = "row">	
<?php
	$query 		="SELECT * FROM user WHERE id='$userID'";
	$result 	= $db->selectData($query);
	if ($result) {
		$userData 	= mysqli_fetch_array($result);
		$dob 		= $userData['dob'];
		$dob	 	= explode('-',$dob);
		$birthyear 	= intval($dob[0]);
		$birthmonth = intval($dob[1]);
		$birthday 	= intval($dob[2]);
	}?>	


	
		<section class="userprofile">
<?php 
	if(isset($_SESSION['msg'])){ ?>
		<div class="success">		
<?php
	echo $_SESSION['msg']; 
	unset($_SESSION['msg']);
?>
</div>	
<?php }?>
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="profilecontent">
					<h3>Personal Information</h3>
					<table width="100%">
						<tr>
							<td width="30%">First Name</td>
							<td width="10%">:</td>
							<td width="60%"><?php echo $userData['firstname'];?></td>
						</tr>

						<tr>
							<td>Last Name</td>
							<td>:</td>
							<td><?php echo $userData['lastname'];?></td>
						</tr>

						<tr>
							<td>Gender</td>
							<td>:</td>
							<td><?php echo $userData['gender'];?></td>
						</tr>

						<tr>
							<td>Date of Birth</td>
							<td>:</td>
							<td><?php echo $birthday.'/'.$birthmonth.'/'.$birthyear;?></td>
						</tr>

						<tr>
							<td>Age</td>
							<td>:</td>
							<td><?php echo $fm->calculateAge($birthyear,$birthmonth,$birthday);?></td>
						</tr>

		<?php
			if(!empty($userData['cell_no'])){
		?>			
						<tr>
							<td>Cell</td>
							<td>:</td>
							<td><?php echo $userData['cell_no']?></td>
						</tr>
		<?php }?>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><?php echo $userData['email']?></td>
						</tr>
					</table>
				</div>
			</div>

				<div class="col-xs-12 col-sm-12 col-md-3">
				<div class="profileimage">
<?php				
        if(!empty($userData['pimg'])){
        	
           echo '<img src="user_image/'.$userData['pimg'].'"/>'; 
           echo '<h3>Update profile picture</h3>'; 
        }else{
           
        echo '<h3>Upload your profile picture</h3>';
           if($userData['gender']=='Male'){
                echo $maleavatar; 
            } else {
              echo $femaleavatar; 
            }
        }
    ?>


    <?php
    	if (isset($_POST['submit_cell'])) {
    		if (empty($userData['cell_no'])) {
    			$cell_no = $_POST['cell_no'];

	    		$query = "UPDATE  user SET cell_no = '$cell_no'  WHERE id='$userID'";
	    		$cell_update = $db->updateData($query);

	    		if ($cell_update) {
					$_SESSION['msg']			= 'Number Inserted Successfully';
				}
    		}else {
    			$cell_no = $_POST['cell_no'];

    		$query = "UPDATE  user SET cell_no = '$cell_no'  WHERE id='$userID'";
    		$cell_update = $db->updateData($query);

    		if ($cell_update) {
				$_SESSION['msg']			= 'Number Updated Successfully';
			}
    		}
    		
    	}
    ?>
					<form action="" method="post" enctype="multipart/form-data">
							<label class="butn">Browse..
							<input class="inputfile" type="file" name="image" size="60" /></label>

							<label class="butn"> Upload This <input type="submit" name="upload" value="Upload Image"> </label>
							
					</form>					
				</div>
				<div class="profileimage">
				<form action="" method="post">
		
	<?php
	if(empty($userData['cell_no'])){
	?>	
					<input type="text" name="cell_no" placeholder="Enter Your Cell Number" />
	<?php } else {?>
					<input type="text" name="cell_no" placeholder="Update Your Cell Number"/>
	<?php }?>									
					<label class="butn"> Submit <input type="submit" name="submit_cell"> </label>			
				</form>
			</div>
<?php
    	if (isset($_POST['update_pass'])) {
    			$password = $_POST['password'];
    			$password = md5($password);

	    		$query = "UPDATE  user SET password = '$password'  WHERE id='$userID'";
	    		$cell_update = $db->updateData($query);

	    		if ($cell_update) {
					$_SESSION['msg']			= 'Password Updated Successfully';

				}
			}
    ?>
			<div class="profileimage">
				<form action="" method="post">
		
					<input type="text" name="password" placeholder="Change Your Password" />							
					<label class="butn"> Change <input type="submit" name="update_pass"> </label>			
				</form>
			</div>
<?php
    	if (isset($_POST['update_email'])) {
    			$email = $_POST['email'];

	    		$query = "UPDATE  user SET email = '$email'  WHERE id='$userID'";
	    		$cell_update = $db->updateData($query);

	    		if ($cell_update) {
					$_SESSION['msg']			= 'Email Updated Successfully';
				}
			}
    ?>
			<div class="profileimage">
				<form action="" method="post">
		
					<input type="email" name="email" placeholder="Change Your Email" />							
					<label class="butn"> Change <input type="submit" name="update_email"> </label>			
				</form>
			</div>

			</div>

		</section>
	</div>
</div>
<?php include_once 'inc/footer.php'?>