<div class = 'mealList'>
	<form action="" method="post">
		<div class="meal-date">
			<p>Date : </p><input type="date" name="mealdate" value="<?php echo date("Y-m-d") ?>" required/>
		</div>
		<table width="100%">
			<tr><td><input type="checkbox" id="select_all">Select All</td></tr>
			<tr>
				<th width="40%">Name</th>
				<th width="20%">Breakfast</th>
				<th width="20%">Lunch</th>
				<th width="20%">Dinner</th>
			</tr>
			
<?php 
	$Month  = date('m');
	$Year 	= date('Y');
	$Date  	= date("Y-m-d");
	$query = "SELECT * FROM user WHERE id = '$userID'";
	$result = $db->selectData($query);
		if ($result) {
			$userData 	= mysqli_fetch_array($result);
			$messId		= $userData['m_id'];
		}

	$query = "SELECT * FROM user WHERE m_id = '$messId' ORDER BY id ASC";
	$result = $db->selectData($query);
		if ($result) {

	 		while ($user = $result->fetch_assoc()) {
	 			$id = $user['id'];
	 			$query = "SELECT * FROM dailymeal WHERE day = '$Date' AND u_id ='$id' ORDER BY u_id ASC";
				$mealQuery = $db->selectData($query);
					if ($mealQuery) {
				 		$mealData = $mealQuery->fetch_assoc();
					}
	 	
			$fname = $user['firstname'];
			$lname = $user['lastname'];
?>
			<tr>
				<td><input type="checkbox" class="checkbox" name="m_member[]" value="<?php echo $user['id'];?>"> <?php echo $user['firstname'];?></td>	
				<td><input type="number" name="breakfast[]" min="0" max="10" step=".5" value="<?php if (empty($mealData)){echo 0;}else { echo $mealData['breakfast'];}?>" required/></td>
				<td><input type="number" name="lunch[]" min="0" max="10" step=".5" value="<?php if (empty($mealData)){echo 0;}else {echo $mealData['lunch'];}?>"  required/></td>
				<td><input type="number" name="dinner[]" min="0" max="10" step=".5" value="<?php if (empty($mealData)){echo 0;}else { echo $mealData['dinner'];}?>" required/></td>
			</tr>
			<?php }	}?>
			</table>
				<button class="sub-btn" type="submit" name="addmeal">ADD</button>
				<button class="sub-btn" type="submit" name="updatemeal">Update</button>		
	</form>
</div>


<?php
if(isset($_POST['addmeal'])){
	if (!isset($_POST['m_member'])) {
		Session::set('successmsg', "<div class = 'error blink'>Please Select Member</div>");
		echo "<script>window.location = 'mealmanage.php';</script>";
	}else{
	$member 	= $_POST['m_member'];
	$breakfast 	= $_POST['breakfast'];
	$lunch 		= $_POST['lunch'];
	$dinner 	= $_POST['dinner'];
	$date		= strtotime($_POST['mealdate']);
	$date		= date("Y-m-d" ,$date);
	$countmember 	= sizeof($member);
	$countbreakfast 	= sizeof($breakfast);
	$countlunch 	= sizeof($lunch);
	$countdinner 	= sizeof($dinner);
	$insert = 0;

	for ($i=0; $i < $countmember; $i++) { 
		$query 	= "SELECT * FROM dailymeal WHERE Day = '$date' AND u_id = '$member[$i]'";
		$result = $db->selectData($query);
		if(!$result){
			$query = "INSERT INTO dailymeal (u_id, m_id, day, breakfast, lunch, dinner) VALUES ($member[$i], $messId, '$date', $breakfast[$i], $lunch[$i], $dinner[$i])";
			$insertData = $db->createData($query);
			$insert = $i;
		}
	}
	if ($insert+1 == $countmember) {
			echo "<script>alert('Inserted Successfully')</script>";
			echo "<script>window.location = 'mealmanage.php';</script>";
		}else{
			Session::set('successmsg', "<div class = 'errors blink'>These records have already been added. You may update these data</div>");
			echo "<script>window.location = 'mealmanage.php';</script>";
		}	
 	}
 }

?>

<?php
if(isset($_POST['updatemeal'])){
	if (!isset($_POST['m_member'])) {
		Session::set('successmsg', "<div class = 'error blink'>Please Select Member</div>");
		echo "<script>window.location = 'mealmanage.php';</script>";
	}else{
	$member 	= $_POST['m_member'];
	$breakfast 	= $_POST['breakfast'];
	$lunch 		= $_POST['lunch'];
	$dinner 	= $_POST['dinner'];
	$date		= strtotime($_POST['mealdate']);
	$date		= date("Y-m-d" ,$date);
	$countmember 	= sizeof($member);
	$countbreakfast 	= sizeof($breakfast);
	$countlunch 	= sizeof($lunch);
	$countdinner 	= sizeof($dinner);
	for ($i=0; $i < $countmember; $i++) { 
		$query 	= "SELECT * FROM dailymeal WHERE Day = '$date' AND u_id = '$member[$i]'";
		$result = $db->selectData($query);
		if ($result) {
			$row    = mysqli_num_rows($result);
			if ($row > 0) {
				$query = "UPDATE dailymeal SET breakfast =$breakfast[$i], lunch = $lunch[$i], dinner = $dinner[$i] WHERE u_id = $member[$i] AND day = '$date' AND m_id = $messId";
				$updateData = $db->updateData($query);
				}
			}
			
		}
		if ($updateData) {
			echo "<script>alert('Updated Successfully')</script>";
			echo "<script>window.location = 'mealmanage.php';</script>";
		}else{
			Session::set('successmsg', "<div class = 'errors blink'>Haven't found any previous data to update. Please first add data.</div>");
			echo "<script>window.location = 'mealmanage.php';</script>";
		}	
	}
	
 }

?>

<script type="text/javascript">
	var select_all = document.getElementById("select_all"); //select all checkbox
var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

//select all checkboxes
select_all.addEventListener("change", function(e){
    for (i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = select_all.checked;
    }
});


for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(this.checked == false){
            select_all.checked = false;
        }
        //check "select all" if all checkbox items are checked
        if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
            select_all.checked = true;
        }
    });
}
</script>