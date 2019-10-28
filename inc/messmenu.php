<?php
	$id = $_SESSION['userID'];
	$query = "SELECT * FROM user WHERE id=$id";
	$result = $db->selectData($query);
	
	if ($result) {
		$userData = mysqli_fetch_array($result);
		$messID = $userData['m_id'];
	}
			$query = "SELECT * FROM mess WHERE id=$messID";
			$result = $db->selectData($query);
			if ($result) {
				$messData 	= mysqli_fetch_array($result);
				$messName 	= $messData['name'];
				$messHN  	= $messData['houseno'];
				$messRN 	= $messData['roadno'];
				$messArea 	= $messData['area'];
				$messCity 	= $messData['city'];
				$messCreator 	= $messData['creator'];
?>

		<div class="mess-profile">
			<div class="mess-header">
				<a href="mymess.php"><h2><span class="mname"><?php echo $messName;?></span></h2></a>
			</div>
			<div class="dropdown">
				<div class="mess-Menu-btn dropdown-toggle" id="menu1" data-toggle="dropdown">
					<i class="fas fa-angle-down"></i>
					</div>
					<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
<?php
	$query 	= "SELECT * FROM user WHERE m_id ='$messID' AND id = '$id' ORDER BY id ASC";
	$result 	= $db->selectData($query);
	if ($result) {
		$user = $result->fetch_assoc();
		if ($user) {
			if($user['role'] == 1){
		
?>
				      <li role="presentation"><a role="menuitem" tabindex="-1" href="addmember.php">Add Member</a></li>
				      <li role="presentation"><a role="menuitem" tabindex="-1" href="removemember.php">Remove Member</a></li>				      
				      <li role="presentation"><a role="menuitem" tabindex="-1" href="setrole.php">Set Role</a></li>
<?php }?>			
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="mealmanage.php">Meal Management</a></li>			 
				      <li role="presentation"><a role="menuitem" tabindex="-1" href="mealcharts.php">Meal Chart</a></li>
				      
				      <li role="presentation"><a role="menuitem" tabindex="-1" href="monthlyledger.php">Ledger</a></li>    
<?php }}}?>				    
				    </ul>
				
			</div>
		</div>