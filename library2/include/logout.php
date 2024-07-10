<?php
    include('include/dbcon.php');
    include('session.php');

    session_start();
    session_destroy();

    header('location:../user_login.php');
?>