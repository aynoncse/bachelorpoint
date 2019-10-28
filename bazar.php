<div class = 'mealList'>
<form action="" method="post">
		<div class="meal-date">
			<input style="width: 100%;" type="date" name="bazardate" value="<?php echo date("Y-m-d") ?>" required/>
		</div>
		<table width="70%" style="margin: 0 auto;">
			<tr>
				<td>
					<select style="width: 75%; margin: 0 0 0 53px" name='u_id' required> 
						<option value=''>Select Name</option>
						<option value='0'>Monthly Bazar</option>
<?php 
	$Date  	= date("Y-m-d");
	$query = "SELECT * FROM user WHERE id = '$userID'";
	$result = $db->selectData($query);
		if ($result) {
			$userData 	= mysqli_fetch_array($result);
			$messId		= $userData['m_id'];
		}

	$query = "SELECT * FROM user WHERE m_id = '$messId'";
	$result = $db->selectData($query);
		if ($result) {

	 		while ($user = $result->fetch_assoc()) {
	 			$id = $user['id'];
	 	
			$fname = $user['firstname'];
			$lname = $user['lastname'];
?>

			<option value = '<?php echo $id?>'><?php echo $fname." ".$lname ?></option>
<?php } }?>
					</select>
				</td>
			</tr>

			<tr>
				<td><input type="text" placeholder="Item Name" style="width: 75%; margin:0 0 0 53px;" name="item" required/></td>
			</tr>

			<tr>
				<td><input style="width: 75%; margin:0 0 0 53px;" placeholder="Quantity" type="text" name="quantity" required/></td>
			</tr>

			<tr>
				<td><input style="width: 75%; margin:0 0 0 53px;" type="number" placeholder="Price" name="price" required/></td>
			</tr>

		</table>
		<button class="sub-btn" type="submit" name="addBazar">Add</button>
		<button class="sub-btn" type="submit" name="updatebazar">Update</button>	
	</form>
</div>


<?php
if(isset($_POST['addBazar'])){
	$id 		= $_POST['u_id'];
	$item		= $_POST['item'];
	$quantity	= $_POST['quantity'];
	$price 		= $_POST['price'];
	$bazarDate	= strtotime($_POST['bazardate']);
	$bazarDate	= date("Y-m-d" ,$bazarDate);

	//$query 		= "SELECT * FROM dailybazar WHERE Day = '$bazarDate' AND u_id = '$id'";
	//$result		= $db->selectData($query);
	//if(!$result){
		$query	= "INSERT INTO dailybazar (u_id, m_id, item, quantity, price, day) VALUES ($id, $messId, '$item', '$quantity', $price, '$bazarDate')";
		$result = $db->createData($query);
		if ($result) {
			echo "<script>alert('Inserted Successfully')</script>";
		}else {
			echo "<script>alert('Failed..!!')</script>";
		}
	//} else {
	//	echo "This records have already been inserted";
	//}
 }

?>