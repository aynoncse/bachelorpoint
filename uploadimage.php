
<?php
	if (isset($_FILES['image'])) {	
		$userID = $_SESSION['userID'];
		$filename = time().$_FILES['image']['name'];
		$filetmp = $_FILES['image']['tmp_name'];
		$filesize = $_FILES['image']['size'];
		$filetypes = $_FILES['image']['type'];

		$extension =strtolower(substr($filename, strrpos($filename, '.')+1)) ;

		$maxsize = 15728640;
		if (!empty($filename) && $filesize<=$maxsize && $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'png') {
      

      // folder image unlink start here

			$query ="SELECT * FROM user WHERE id='$userID'";
			$result = $db->selectData($query);
			if ($result) {
				$userData = mysqli_fetch_array($result);
			}
			 $userImage   =  $userData['pimg'];
			 $unlinkPath  = "user_image/".$userImage;

			 if(!empty($userImage)){
			 	unlink($unlinkPath);
			 }
			 // folder image unlink end here
			
			$update_image="UPDATE  user SET pimg = '$filename'  WHERE id='$userID'";
			$result = $db->updateData($update_image);
			if ($result) {
				move_uploaded_file($filetmp, "user_image/".$filename);

				$_SESSION['msg']			= 'Image uploaded successfully';
			}
		}
		else {
			$_SESSION['msg'] = "Please choose an image within maximum size of 4MB";
		}
	}
?>