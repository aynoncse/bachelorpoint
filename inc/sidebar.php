
	<div id="mySidenav" class="sidenav">
		<a style="background: none; margin: 0; padding: 0;" href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			<a style="margin-top: -15px;" href="index.php">Home</a>
<?php
	$id = $_SESSION['userID'];
	$query = "SELECT * FROM user WHERE id=$id";
	$result = $db->selectData($query);
	
	if ($result) {
		$userData = mysqli_fetch_array($result);
		if ($userData['m_id']!=0) {
?>			
			<a href="mymess.php">My Mess</a>
<?php }else{?>
			<a href="createmess.php">Create Mess</a> 
<?php }}?>    
	</div>
	<div style="position: fixed; top:60px; z-index: 1"><span style="font-size:30px;cursor:pointer;color: #CACACA;" onclick="openNav()"><i class="fab fa-elementor"></i></span>
	</div>
