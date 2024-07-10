<?php include ('include/header.php'); ?>
<!-- LOGO HEADER END-->
<?php include ('include/navbar.php'); ?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
    <div class="container">
        <!--LOGIN PANEL START-->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        User LOGIN FORM
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">

                            <div class="form-group">
                                <label>Enter University Id</label>
                                <input class="form-control" type="text" name="uni_id" required autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="password" name="password" required
                                    autocomplete="off" />
                            </div>

                            <button type="submit" name="login" class="btn btn-info">LOGIN </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!---LOGIN PABNEL END-->


    </div>
</div>
<?php
        include('include/dbcon.php');

        if (isset($_POST['login'])){

        $uniId=$_POST['uni_id'];
        $password=$_POST['password'];

        $login_query=mysqli_query($con,"select * from user where university_number='$uniId' and password='$password'");
        $count=mysqli_num_rows($login_query);
        $row=mysqli_fetch_array($login_query);

        if ($count > 0){
            session_start();
            $_SESSION['user_id']=$row['user_id'];

            echo "<script>alert('User Logged in Successfully'); window.location='user_home.php'</script>";
        }else{ ?>
<div class="alert alert-danger">
    <h3 class="blink_text">Invalid Credentials</h3>
</div>
<?php
        }
     }
    ?>
<!-- CONTENT-WRAPPER SECTION END-->
<?php include ('include/footer.php'); ?>

</body>

</html>