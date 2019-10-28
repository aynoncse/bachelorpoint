<?php include_once 'inc/header.php'?>
<div class = "container-fluid">
	<div class = "row">
		<?php include_once 'inc/sidebar.php'?>		
		<div class="col-xs-12 col-sm-12 col-md-12"">
			<div class = "content">
				<div class = "container-fluid">
					<?php if (isset($_SESSION['successmsg'])) : ?>
						<div class="error success" >
							<h4>
								<?php 
										
										echo $_SESSION['successmsg'];
										unset($_SESSION['successmsg']);
								?>
							</h4>
							
						</div>
					<?php endif ?>
					
					<?php
						$query 	= "SELECT * FROM user ORDER BY id ASC";
						$result 	= $db->selectData($query);
						if ($result) {
							while ($user = $result->fetch_assoc()) {
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
							 <p>Gender : <?php echo $user['gender'];?></p>
							 <p>Email : <?php echo $user['email'];?></p>
						 </div>
					</div>
				<?php } }?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once 'inc/footer.php'?>