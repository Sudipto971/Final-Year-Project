<?php include ('header.php'); ?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <small>Home /</small> Borrowed Requested Books
        </h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i> Borrowed Books Monitoring</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
                <!--- sort -->
                <form method="GET" action="" class="form-inline">
                    <div class="control-group">
                        <div class="controls">
                            <div class="col-md-3">
                                <input type="date" style="color:black;" value="<?php echo date('Y-m-d'); ?>"
                                    name="datefrom" class="form-control has-feedback-left" placeholder="Date From"
                                    aria-describedby="inputSuccess2Status4" required />
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div class="col-md-3">
                                <input type="date" style="color:black;" value="<?php echo date('Y-m-d'); ?>"
                                    name="dateto" class="form-control has-feedback-left" placeholder="Date To"
                                    aria-describedby="inputSuccess2Status4" required />
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="search" class="btn btn-primary btn-outline"><i
                            class="fa fa-calendar-o"></i> Search</button>

                </form>
            </div>
            <div class="x_content">
                <!-- content starts here -->

                <div class="table-responsive">
                    <?php
							$where ="";
							if(isset($_GET['search'])){
								$where = " and (date(borrow_request.requested_date) between '".date("Y-m-d",strtotime($_GET['datefrom']))."' and '".date("Y-m-d",strtotime($_GET['dateto']))."' ) ";
							}
							
							$return_query= mysqli_query($con,"SELECT * from borrow_request 
							LEFT JOIN book ON borrow_request.book_id = book.book_id 
							LEFT JOIN user ON borrow_request.user_id = user.user_id 
							$where") or die (mysqli_error());
								$return_count = mysqli_num_rows($return_query);
							?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                        id="example">

                        <!-- <div class="pull-left">
                                    <div class="span"><div class="alert alert-info"><i class="icon-credit-card icon-large"></i>&nbsp;Total Amount of Penalty:&nbsp;<?php echo "Php ".$count_penalty_row['sum(book_penalty)'].".00"; ?></div></div>
                                </div> -->

                        <thead>
                            <tr>
                                <th>Borrower Name</th>
                                <th>Title</th>
                                <th>Borrowed Requested Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							while ($return_row= mysqli_fetch_array ($return_query) ){
							$id=$return_row['borrow_book_id'];
?>
                            <tr>
                                <td style="text-transform: capitalize">
                                    <?php echo $return_row['firstname']." ".$return_row['lastname']; ?></td>
                                <td style="text-transform: capitalize"><?php echo $return_row['book_title']; ?></td>
                                <td><?php echo date("M d, Y h:m:s a",strtotime($return_row['requested_date'])); ?></td>
                                <td>
                                    <!-- <a href="issued_book.php<?php echo '?book_id='.$return_row['borrow_book_id']; ?>"
                                        class="btn btn-success">Issue</a> -->
                                    <form method="post">
                                        <input type="hidden" name="user_id"
                                            value="<?php echo $return_row['user_id'] ?>">
                                        <input type="hidden" name="book_id"
                                            value="<?php echo $return_row['book_id'] ?>">
                                        <button name="borrow" class="btn btn-info"><i class="fa fa-check"></i>
                                            Issue</button>
                                    </form>
                                </td>
                            </tr>

                            <?php 
							}
							if ($return_count <= 0){
								echo '
									<table style="float:right;">
										<tr>
											<td style="padding:10px;" class="alert alert-danger">No Books request at this moment</td>
										</tr>
									</table>
								';
							} 							
							?>
                        </tbody>
                    </table>
                </div>
                <?php 
                        $allowable_days_query= mysqli_query($con,"select * from allowed_days order by allowed_days_id DESC ") or die (mysqli_error());
                        $allowable_days_row = mysqli_fetch_assoc($allowable_days_query);
                        
                        $timezone = "Asia/Manila";
                        if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
                        $cur_date = date("Y-m-d H:i:s");
                        $date_borrowed = date("Y-m-d H:i:s");
                        $due_date = strtotime($cur_date);
                        $due_date = strtotime("+".$allowable_days_row['no_of_days']." day", $due_date);
                        $due_date = date('Y-m-d H:i:s', $due_date);
                        if (isset($_POST['borrow'])){
                            $user_id =$_POST['user_id'];
                            $book_id =$_POST['book_id'];
                            
                            $trapBookCount= mysqli_query($con,"SELECT count(*) as books_allowed from borrow_book where user_id = '$user_id' and borrowed_status = 'borrowed'") or die (mysqli_error());
									
                            $countBorrowed = mysqli_fetch_assoc($trapBookCount);
                            
                            $bookCountQuery= mysqli_query($con,"SELECT count(*) as book_count from borrow_book where user_id = '$user_id' and borrowed_status = 'borrowed' and book_id = $book_id") or die (mysqli_error());
                            
                            $bookCount = mysqli_fetch_assoc($bookCountQuery);
                            
                            $allowed_book_query= mysqli_query($con,"select * from allowed_book order by allowed_book_id DESC ") or die (mysqli_error());
                            $allowed = mysqli_fetch_assoc($allowed_book_query);

                            if ($countBorrowed['books_allowed'] == $allowed['qntty_books']){
                                echo "<script>alert(' ".$allowed['qntty_books']." ".'Books Allowed per User!'." '); window.location='admin_borrowed_requested.php'</script>";
                            }elseif ($bookCount['book_count'] == 1){
                                echo "<script>alert('Book Already Borrowed!'); window.location='admin_borrowed_requested'</script>";
                            }else{
                                $update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
                                $copies_row= mysqli_fetch_assoc($update_copies);
                                
                                $book_copies = $copies_row['book_copies'];
                                $new_book_copies = $book_copies - 1;

                                if ($new_book_copies < 0){
                                    echo "<script>alert('Book out of Copy!'); window.location='admin_borrowed_requested'</script>";
                                }elseif ($copies_row['status'] == 'Damaged'){
                                    echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='admin_borrowed_requested'</script>";
                                }elseif ($copies_row['status'] == 'Lost'){
                                    echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='admin_borrowed_requested'</script>";
                                }else{
                                    if ($new_book_copies == '0') {
										$remark = 'Not Available';
									} else {
										$remark = 'Available';
									}
                                    
                                    mysqli_query($con,"UPDATE book SET book_copies = '$new_book_copies' where book_id = '$book_id' ") or die (mysqli_error());
									mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id' ") or die (mysqli_error());
									
									mysqli_query($con,"INSERT INTO borrow_book(user_id,book_id,date_borrowed,due_date,borrowed_status)
									VALUES('$user_id','$book_id','$date_borrowed','$due_date','borrowed')") or die (mysqli_error());
									
									$report_history=mysqli_query($con,"select * from admin where admin_id = $id_session ") or die (mysqli_error());
									$report_history_row=mysqli_fetch_array($report_history);
									$admin_row=$report_history_row['firstname']." ".$report_history_row['middlename']." ".$report_history_row['lastname'];	
									
									mysqli_query($con,"INSERT INTO report 
									(book_id, user_id, admin_name, detail_action, date_transaction)
									VALUES ('$book_id','$user_id','$admin_row','Borrowed Book',NOW())") or die(mysqli_error());

                                    $deleteRequest= mysqli_query($con,"DELETE from borrow_request where user_id = '$user_id' and book_id = '$book_id'") or die (mysqli_error($con));

                                    echo "<script>alert('Book Issued Successfully'); window.location='borrowed.php'</script>";
                                }
                            }
                        }
                ?>

                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>