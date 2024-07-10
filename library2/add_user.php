<?php include ('header.php'); ?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <small>Home / Members</small>
        </h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- content starts here -->

                <form method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">University ID Number <span
                                class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-2">
                            <input type="number" name="university_number" id="first-name2" required="required"
                                class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">First Name <span class="required"
                                style="color:red;">*</span>
                        </label>
                        <div class="col-md-3">
                            <input type="text" name="firstname" placeholder="First Name....." id="first-name2"
                                required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Middle Name
                        </label>
                        <div class="col-md-3">
                            <input type="text" name="middlename" placeholder="MI / Middle Name....." id="first-name2"
                                class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Last Name <span class="required"
                                style="color:red;">*</span>
                        </label>
                        <div class="col-md-3">
                            <input type="text" name="lastname" placeholder="Last Name....." id="last-name2"
                                required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Contact
                        </label>
                        <div class="col-md-3">
                            <input type="tel" pattern="[0-9]{11,11}" autocomplete="off" maxlength="11" name="contact"
                                id="last-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Gender <span class="required"
                                style="color:red;">*</span>
                        </label>
                        <div class="col-md-4">
                            <select name="gender" class="select2_single form-control" required="required" tabindex="-1">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Address
                        </label>
                        <div class="col-md-4">
                            <input type="text" name="address" id="last-name2" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">Type <span class="required"
                                style="color:red;">*</span>
                        </label>
                        <div class="col-md-4">
                            <select name="type" class="select2_single form-control" required="required" tabindex="-1">
                                <option value="Student">Student</option>
                                <option value="Teacher">Teacher</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="last-name">batch <span class="required"
                                style="color:red;">*</span>
                        </label>
                        <div class="col-md-4">
                            <select name="batch" class="select2_single form-control" required="required" tabindex="-1">
                                <option value="4th year 2nd semester">8th semester</option>
                                <option value="4th year 1st semester">7th semester</option>
                                <option value="3rd year 2nd semester">6th semester</option>
                                <option value="3rd year 1st semester">5th semester</option>
                                <option value="2nd year 2nd semester">4th semester</option>
                                <option value="2nd year 1st semester">3rd semester</option>
                                <option value="1st year 2nd semester">2nd semester</option>
                                <option value="1st year 1st semester">1st semester</option>
                                <option value="Faculty">Faculty</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="first-name">Session <span class="required"
                                style="color:red;">*</span>
                        </label>
                        <div class="col-md-3">
                            <input type="text" name="session" placeholder="session....." id="first-name2"
                                required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <a href="user.php"><button type="button" class="btn btn-primary"><i
                                        class="fa fa-times-circle-o"></i> Cancel</button></a>
                            <button type="submit" name="submit" class="btn btn-success"><i
                                    class="fa fa-plus-square"></i> Submit</button>
                        </div>
                    </div>
                </form>

                <?php	
							include ('include/dbcon.php');
                if (isset($_POST['submit'])){
									$university_number = $_POST['university_number'];
									$firstname = $_POST['firstname'];
									$middlename = $_POST['middlename'];
									$lastname = $_POST['lastname'];
									$contact = $_POST['contact'];
									$gender = $_POST['gender'];
									$address = $_POST['address'];
									$type = $_POST['type'];
									$batch = $_POST['batch'];
									$session = $_POST['session'];
					
					$result=mysqli_query($con,"select * from user WHERE university_number='$university_number' ") or die (mysqli_error());
					$row=mysqli_num_rows($result);
					if ($row > 0)
					{
					echo "<script>alert('ID Number already active!'); window.location='user.php'</script>";
					}
					else
					{		
						mysqli_query($con,"insert into user (university_number,firstname, middlename, lastname, contact, gender, address, type, batch, session, status, user_added)
						values ('$university_number','$firstname', '$middlename', '$lastname', '$contact', '$gender', '$address', '$type', '$batch', '$session', 'Active', NOW())")or die(mysqli_error());
						echo "<script>alert('User successfully added!'); window.location='user.php'</script>";
					}
							}
								?>

                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>