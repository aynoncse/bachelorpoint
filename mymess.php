<?php include_once 'inc/header.php'?>
<div class = "container-fluid">
	<div class = "row">
		<?php include_once 'inc/sidebar.php'?>		
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class = "content">
				<div class = "container-fluid">
<?php include_once 'inc/messmenu.php'?>				
<?php
	$query 	= "SELECT * FROM user WHERE m_id ='$messID' ORDER BY id ASC";
	$result 	= $db->selectData($query);
	if ($result) {
		while ($user = $result->fetch_assoc()) {

			$dob 		= $user['dob'];
			$dob	 	= explode('-',$dob);
			$birthyear 	= intval($dob[0]);
			$birthmonth = intval($dob[1]);
			$birthday 	= intval($dob[2]);

			$dateObj   = DateTime::createFromFormat('!m', $birthmonth);
			$birthmonth = $dateObj->format('F');
?>

					<div class = 'col-sm-6 col-md-3'>
						<div class='usersinfo'>
					
						 	<div class='userslistimage'>

						 		<?php
                    if (!empty($user['pimg'])) {
                ?>
                      <img src="user_image/<?php echo $user['pimg'];?>"/>
                <?php
                  }else{
                    if ($user['gender']=='Male') {
                      echo $maleavatar;
                    }else{
                      echo $femaleavatar;
                    }
                  }
                ?>		
						 						 			
						 	</div>						 
							 <p>Name : <?php echo $user['firstname'].' '.$user['lastname'];?></p>
							 <p>Email : <?php echo $user['email'];?></p>
							 <p>Role : 
					 <?php 
					 	if($user['role'] == 1){
					 		echo "Director";
 					 	}elseif($user['role'] == 2){
					 		echo "Manager";
 					 	}else {
 					 		echo "Member";
 					 	}
					 ?>
							 	
							 </p>
							 <p>Cell : <?php echo $user['cell_no'];?></p>
							 <p>Date of Birth : <?php echo " &nbsp;".$birthday." - ".$birthmonth;?></p> 
						 </div>
					</div>
				<?php } }?>
				</div>

		</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once 'inc/footer.php'?>