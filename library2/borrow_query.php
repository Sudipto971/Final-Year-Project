<?php 
	include ('include/dbcon.php');
	
	if (isset($_POST['submit'])) {
	
	$university_number = $_POST['university_number'];
	
	$sql = mysqli_query($con,"SELECT * FROM user WHERE university_number = '$university_number' ");
	$count = mysqli_num_rows($sql);
	$row = mysqli_fetch_array($sql);
	
		if($count <= 0){
			echo "<div class='alert alert-success'>".'No match found for the university ID Number'."</div>";
		}else{
			$university_number = $_POST['university_number'];
			header('location: borrow_book.php?university_number='.$university_number);
		} 
	}
?>