            <!-- sidebar navigation -->
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="home.php" class="site_title"><i class="fa fa-university"></i> <span>LMS
                                BAUET</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <a href="admin_profile.php">
                        <div class="profile">
                            <?php
                                $user_query=mysqli_query($con,"select *  from user where user_id='$user_session'")or die(mysqli_error());
                                $row=mysqli_fetch_array($user_query); {
                            ?>
                            <div class="profile_pic">
                                <?php if($row['user_image'] != ""): ?>
                                <img src="upload/<?php echo $row['user_image']; ?>" style="height:65px; width:75px;"
                                    class="img-thumbnail profile_img">
                                <?php else: ?>
                                <img src="images/uni.png" style="height:65px; width:75px;"
                                    class="img-circle profile_img">
                                <?php endif; ?>
                            </div>

                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2><?php echo $row['firstname']; ?></h2>
                            </div>
                            <?php } ?>
                        </div>
                    </a>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3 style="margin-top:85px;">File Information</h3>
                            <div class="separator"></div>
                            <ul class="nav side-menu">
                                <li>
                                    <a href="user_home.php"><i class="fa fa-home"></i> Home</a>
                                </li>
                                <li>
                                    <a href="user_book.php"><i class="fa fa-book"></i> Books</a>
                                </li>
                                <li>
                                    <a href="user_borrowed_requested.php"><i class="fa fa-book"></i> Borrowed
                                        Requested</a>
                                </li>
                                <li>
                                    <a href="user_borrowed.php"><i class="fa fa-book"></i> Borrowed Books</a>
                                </li>
                                <li>
                                    <a href="user_return_requested.php"><i class="fa fa-book"></i> Returned
                                        Requested</a>
                                </li>
                                <li>
                                    <a href="user_returned_book.php"><i class="fa fa-book"></i> Returned Books</a>
                                </li>
                                <li>
                                    <a href="admin.php"><i class="fa fa-book"></i> User Profile</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>
            <!-- end of sidebar navigation -->