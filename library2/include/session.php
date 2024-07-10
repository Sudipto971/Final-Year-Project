<?php 
    session_start();
    if (!isset($_SESSION['user_id'])){
    header('location:user_login.php');
    }
    $user_session=$_SESSION['user_id'];
?>