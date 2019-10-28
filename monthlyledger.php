<?php include_once 'inc/header.php'?>

<div class = "container-fluid">
	<div class = "row">	
		<div class = "col-md-12">
		<div class="col-xs-12 col-sm-12 col-md-12">
				<div class = "content-post">
<!-- MESS MENU START-->
<?php
	$TotalCost = $totalCharge = $MealCost = $TotalCost1 = $totalCredit = $totalPaid = $totalBazar = $balance = $totalCredit = $TotalCost =$totalBazar  = $maidBill = $internetBill = $electricBill = $serviceCharge = $othersCharges = 0;

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

		<div class="mess-profile" style="margin:60px 0 0 0">
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
<?php } if($user['role'] == 1 || $user['role'] == 2){ ?>			
					  <li role="presentation"><a role="menuitem" tabindex="-1" href="mealmanage.php">Meal Management</a></li>
<?php } ?>				 
				      <li role="presentation"><a role="menuitem" tabindex="-1" href="mealcharts.php">Meal Chart</a></li>
				      
				      <li role="presentation"><a role="menuitem" tabindex="-1" href="monthlyledger.php">Ledger</a></li>    
<?php }}}?>				    
				    </ul>
				
			</div>
		</div>					
<!-- MESS MENU END-->
				<div class="ledgerform">
					<form action="" method="POST">
						<select name="month">
					    <?php
						    for ($i = 0; $i < 12; $i++) {
						        $time = strtotime(sprintf('%d months', $i));   
						        $label = date('F', $time);   
						        $value = date('n', $time);
						        echo "<option value='$value'>$label</option>";
						    }
					    ?>
					</select>

						<?php
						$current_year = date("Y");
						$earliest_year = 2010;

						echo '<select name="year">';
						foreach (range(date('Y'), $earliest_year) as $x) {
						    echo '<option value="'.$x.'"'.($x === $current_year ? ' selected="selected"' : '').'>'.$x.'</option>';
						}
						echo '</select>';
					?>
						<input type="submit" name="monthlyledger" value="Go"/>
					</form>
				</div>
					<?php
						if (isset($_POST['monthlyledger'])){

							$ledgerMonth = $_POST['month'];
							$ledgerYear = $_POST['year'];

							$selectedMonth = $ledgerMonth."-".$ledgerYear;

							
							$dateObj   = DateTime::createFromFormat('!m', $ledgerMonth);
							$monthName = $dateObj->format('F');

							$mealQuery      = "SELECT * FROM dailymeal WHERE month(day) = '$ledgerMonth' AND year(day)= '$ledgerYear' AND m_id=$messID";
								$mealData = $db->selectData($mealQuery);
								if ($mealData) {
									$mealData   = mysqli_fetch_array($mealData);
									echo "<div class='ledger'>";
									include ('ledger.php');					
								}else{
									echo "<div class ='errors blink' style='text-align: center; font-size: 50px;'>No Data Found...!</div>";
								}

						}
					?>

				</div>
			</div>			

				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once 'inc/footer.php'?>



