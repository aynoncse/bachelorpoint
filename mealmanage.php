<?php include_once 'inc/header.php'?>
<div class = "container-fluid">
	<div class = "row">
		<?php include_once 'inc/sidebar.php'?>		
		<div class="col-xs-12 col-sm-12 col-md-12"">
			<div class = "content">
				<div class = "container-fluid">
<?php include_once 'inc/messmenu.php'?>	

<?php 
	if (isset($_SESSION['successmsg'])){									
		echo $_SESSION['successmsg'];
		unset($_SESSION['successmsg']);
	}
?>
<?php
	$query = "SELECT * FROM user WHERE id='$userID'";
		$result = $db->selectData($query);
		if ($result) {
			$userData = mysqli_fetch_array($result);
			if($user['role'] == 1 || $user['role'] == 2){
?>
					<div class="col-md-4">
					<div class="mealoptions" data-toggle="modal" data-target="#add-meal" data-placement="top" title="Meal Option" ><i class="fas fa-utensils"></i>
					</div>

					<div class="modal fade" id="add-meal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div id ="toogleMeal" class="togglediv"">
							<h2>Daily Meal</h2>

							<?php include ('dailymeal.php'); ?>
						</div>						
					</div>
					</div>

					<div class="col-md-4">
					<div class="mealoptions" data-toggle="modal" data-target="#add-bazar" data-placement="top" title="Add Bazar"><i class="fas fa-shopping-bag"></i>
					</div>

					<div class="modal fade" id="add-bazar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	<div id ="toogleBazar" class="togglediv">
							<h2>Add Bazar</h2>

								<?php include ('bazar.php'); ?>								
						</div>
					</div>
					</div>

					<div class="col-md-4">
					<div class="mealoptions" data-toggle="modal" data-target="#add-payment" data-placement="top" title="Add Payment"><i class="fab fa-paypal"></i>
					</div>

					<div class="modal fade" id="add-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	<div id ="add-payment" class="togglediv">
							<h2>Add Payment</h2>

								<?php include ('payment.php'); ?>							
						</div>
					</div>
					</div>
					
<?php }}?>
					<div class="col-md-4">
					<div class="mealoptions" data-toggle="modal" data-target="#meal-list" data-placement="top" title="Meal Chart"><i class="fa fa-th-list"></i>
					</div>

					<div class="modal fade" id="meal-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	<div id ="meal-list" class="togglediv" style="width: 98%;">
							<h2>Meal Chart for <?php echo date("F-Y")?></h2>
								<?php 
									$thisMonth = date("m");
									$thisYear  = date("Y");
									include ('mealchart.php');
								?>							
						</div>
					</div>
					</div>


					<div class="col-md-4">
					<div class="mealoptions" data-toggle="modal" data-target="#meal-details" data-placement="top" title="Details"><i class="fas fa-database"></i>
					</div>

					<div class="modal fade" id="meal-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	<div id ="meal-details" class="togglediv">
							<h2> Ledger for 
<?php 
	$ledgerMonth = date("m");
	$ledgerYear  = date("Y");
	$dateObj   = DateTime::createFromFormat('!m', $ledgerMonth);
	$monthName = $dateObj->format('F');

	echo $monthName." ".$ledgerYear;
?>									
								</h2>					
								<?php include ('myledger.php'); ?>							
						</div>
					</div>
					</div>

					<div class="col-md-4">
					<div class="mealoptions" data-toggle="modal" data-target="#meal-ledger"data-placement="top" title="Closings"><i class="fas fa-calculator"></i>
					</div>
					<div class="modal fade" id="meal-ledger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">	<div id ="meal-ledger" class="togglediv" style="width: 98%;">
								<?php 
									$ledgerMonth = date("m");
									$ledgerYear  = date("Y");
									$dateObj   = DateTime::createFromFormat('!m', $ledgerMonth);
									$monthName = $dateObj->format('F');

								$mealQuery      = "SELECT * FROM dailymeal WHERE month(day) = '$ledgerMonth' AND year(day)= '$ledgerYear' AND m_id=$messID";
								$mealData = $db->selectData($mealQuery);
								if ($mealData) {
									$mealData   = mysqli_fetch_array($mealData);
									include ('ledger.php');	} ?>							
						</div>
					</div>
				</div>



						

				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once 'inc/footer.php'?>