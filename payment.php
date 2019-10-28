<?php
	$Date  	= date("Y-m-d");
	$query = "SELECT * FROM user WHERE id = '$userID'";
	$result = $db->selectData($query);
	if ($result) {
		$userData 	= mysqli_fetch_array($result);
		$messId		= $userData['m_id'];
	}
?>

<?php
if(isset($_POST['addPayment'])){
	$id 		= $_POST['u_id'];
	$payAmount 	= $_POST['payAmount'];
	$paymentDate	= strtotime($_POST['paydate']);
	$paymentDate	= date("Y-m-d" ,$paymentDate);


	$query 		= "SELECT * FROM account WHERE day = '$paymentDate' AND u_id = $id";
	$result		= $db->selectData($query);

	if(!$result){
		$query	= "INSERT INTO account (u_id, m_id, Paid_Amount, day) VALUES ($id, $messId, $payAmount, '$paymentDate')";
		$result		= $db->createData($query);
		if ($result) {
			echo "<script>alert('Added Successfully')</script>";
		}
	} else {
		echo "<script>alert('This records have already been added. You may update your data.')</script>";
	}
 }

?>

<div class = 'mealList'>
	<form action="" method="post">
		<div class="meal-date">
			<p>Date : </p><input type="date" name="paydate" value="<?php echo date("Y-m-d") ?>" required/>
		</div>
		<table width="60%" style="margin: 0 auto;">
			<tr>
				<td>
					<select style="width: 70%; margin:0 0 0 85px;" name='u_id' required> 
						<option value=''>Select Name</option>
<?php 
	$query = "SELECT * FROM user WHERE m_id = '$messId'";
	$result = $db->selectData($query);
		if ($result) {

	 		while ($user = $result->fetch_assoc()) {
	 			$id = $user['id'];
				$fname = $user['firstname'];
				$lname = $user['lastname'];
?>

			<option value = '<?php echo $id;?>'><?php echo $fname." ".$lname ?></option>
<?php } }?>
					</select>
				</td>
			</tr>
		<tr><td><input style="width: 70%; margin:0 0 0 85px;" type="number" name="payAmount" placeholder="Amount" required/></td></tr>
	</table>

		<button class="sub-btn" type="submit" name="addPayment">Add</button>
		<button class="sub-btn" type="submit" name="updatePayment">Update</button>
	</form>
</div>
<br/>


<?php
	if(isset($_POST['addCharges'])){
		$month 			= $_POST['month'];
		$years 			= $_POST['years'];
		$MaidBill 		= $_POST['MaidBill'];
		$InternetBill	= $_POST['InternetBill'];
		$ElectricBill	= $_POST['ElectricBill'];
		$ServiceCharge	= $_POST['ServiceCharge'];
		$others			= $_POST['others'];
		$query	= "SELECT * FROM charges WHERE month = '$month' AND years = '$years' AND m_id = $messId";
		$result		= $db->selectData($query);

		if(!$result){
			$query	= "INSERT INTO charges (m_id, maid_bill, internet_bill, electric_bill, service_charge, others, month, years) VALUES ($messId, $MaidBill, $InternetBill, $ElectricBill, $ServiceCharge, $others, $month, '$years')";
			$result		= $db->createData($query);
			if ($result) {
				echo "<script>alert('Added Successfully')</script>";
			}
		} else {
			echo "<script>alert('This records have already been added. You may update your data.')</script>";
		}
 	}
?>	

<div class = 'mealList'>
	<h2>Add Charges</h2>
	<form action="" method="post">
		<table width="60%" style="margin: 0 auto;">
			<tr>
				<td>
					<select style="width: 100%;" name="month">
					    <?php
						    for ($i = 0; $i < 12; $i++) {
						        $time = strtotime(sprintf('%d months', $i));   
						        $label = date('F', $time);   
						        $value = date('n', $time);
						        echo "<option value='$value'>$label</option>";
						    }
					    ?>
					</select>
				</td>
				<td>
					<?php
						$current_year = date("Y");
						$earliest_year = 2000;

						echo '<select style="width: 100%;" name="years">';
						foreach (range(date('Y'), $earliest_year) as $x) {
						    echo '<option value="'.$x.'"'.($x === $current_year ? ' selected="selected"' : '').'>'.$x.'</option>';
						}
						echo '</select>';
					?>
				</td>
			</tr>
				
			
			<tr><td colspan="2"><input type="number" name="MaidBill" placeholder="Maid Bill" required/></td></tr>
			<tr><td colspan="2"><input type="number" name="InternetBill" placeholder="Internet Bill" required/></td></tr>
			<tr><td colspan="2"><input type="number" name="ElectricBill" placeholder="Electric Bill" required/></td></tr>
			<tr><td colspan="2"><input type="number" name="ServiceCharge" placeholder="Service Charge" required/></td></tr>
			<tr><td colspan="2"><input type="number" name="others" placeholder="Others Charges" /></td></tr>
		</table>
		<button class="sub-btn" type="submit" name="addCharges">Add</button>
		<button class="sub-btn" type="submit" name="updateCharges">Update</button>

	</form>
</div>
