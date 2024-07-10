<?php
    include('include/dbcon.php');

    session_start();
    $user_id=$_SESSION['user_id'];
    $borrow_book_id=$_GET['borrow_book_id'];
    $cur_date = date("Y-m-d H:i:s");


    mysqli_query($con,"INSERT INTO return_request(borrow_book_id,return_request_date)
                                        VALUES('$borrow_book_id','$cur_date')") or die (mysqli_error($con));

    header('location:user_return_requested.php');
?>