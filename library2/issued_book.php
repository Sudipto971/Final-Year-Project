<?php include ('header.php'); ?>
<?php 
	$borrow_request_id = $_GET['book_id'];
	
	$request_query = mysqli_query($con,"SELECT * FROM lms.borrow_request where borrow_book_id = 3")  or die (mysqli_error());
	$request_row = mysqli_fetch_assoc($user_query);

    echo $request_row;
?>