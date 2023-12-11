<?php
  session_start();
?>
<?php 

if (isset($_POST['submit']) && isset($_FILES['my_image'])) 
{
	include "db_conn.php";

	echo "<pre>";
	print_r($_FILES['my_image']);
	echo "</pre>";
	$user=$_SESSION['username'];
    $price=$_POST['price'];
	$date=$_POST['date'];
	$number=$_POST['number'];
	$cat=$_SESSION['category'];
	$img_name = $_FILES['my_image']['name'];
	$img_size = $_FILES['my_image']['size'];
	$tmp_name = $_FILES['my_image']['tmp_name'];
	$error = $_FILES['my_image']['error'];
 
	if ($error === 0) {
		
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$allowed_exs = array("jpg", "jpeg", "png"); 

			if (in_array($img_ex_lc, $allowed_exs)) {
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$img_upload_path = 'uploads/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);

				// Insert into Database
				if($_SESSION['category']=='carpooling')
				{
					$from=$_POST['from'];
	                $to=$_POST['to'];
					$time=$_POST['time'];
				$sql = "INSERT INTO images(user,category,image_url,number,`from`,`to`,price,date,`time`) 
				        VALUES('$user','$cat','$new_img_name','$number','$from','$to','$price','$date','$time')";
				mysqli_query($conn, $sql);
				echo "<script>alert('Posted')</script>";
				echo '<script type="text/javascript">
                window.location.href = "site1.php";
            </script>';
			}
			else if($_SESSION['category']=='ticketsharing')
			{
				$venue=$_POST['venue'];
	            $event=$_POST['event'];
				$time=$_POST['time'];
				$sql = "INSERT INTO images(user,category,image_url,number,venue,event,price,date,`time`) 
				        VALUES('$user','$cat','$new_img_name','$number','$venue','$event','$price','$date','$time')";
				mysqli_query($conn, $sql);
				echo "<script>alert('Posted')</script>";
				echo '<script type="text/javascript">
                window.location.href = "site1.php";
            </script>';
			}
			else if($_SESSION['category']=='roomsharing')
			{
				$landmark=$_POST['landmark'];
				$people=$_POST['people'];
				$sql = "INSERT INTO images(user,category,image_url,number,landmark,no_of_people,price,date) 
				        VALUES('$user','$cat','$new_img_name','$number','$landmark','$people','$price','$date')";
				mysqli_query($conn, $sql);
				echo "<script>alert('Posted')</script>";
				echo '<script type="text/javascript">
                window.location.href = "site1.php";
            </script>';
			}
		}
			else {
				$em = "You can't upload files of this type";
		       echo $em;
			}
		}
		
	else {
		$em = "unknown error occurred!";
		header("Location: index.php?error=$em");
	}
	
}
else {
	header("Location: index.php");
}
?>