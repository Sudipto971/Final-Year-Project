<?php 

include('include/dbcon.php');

session_start();
$user_id=$_SESSION['user_id'];
$book_id=$_GET['book_id'];
$cur_date = date("Y-m-d H:i:s");


mysqli_query($con,"INSERT INTO borrow_request(user_id,book_id,requested_date)
									VALUES('$user_id','$book_id','$cur_date')") or die (mysqli_error($con));

header('location:user_borrowed_requested.php');
?>