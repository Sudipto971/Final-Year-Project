<?php include ('header.php'); ?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <small>Home /</small> Return Requested Books
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
								$where = " and (date(return_request.requested_date) between '".date("Y-m-d",strtotime($_GET['datefrom']))."' and '".date("Y-m-d",strtotime($_GET['dateto']))."' ) ";
							}
							
							$return_query= mysqli_query($con,"SELECT * from return_request 
                            LEFT JOIN borrow_book ON  return_request.borrow_book_id = borrow_book.borrow_book_id
							LEFT JOIN book ON borrow_book.book_id = book.book_id 
							LEFT JOIN user ON borrow_book.user_id = user.user_id 
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
                                <th>Return Requested Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							while ($return_row= mysqli_fetch_array ($return_query) ){
                                $id=$return_row['borrow_book_id'];
                                $due_date= $return_row['due_date'];

                                $timezone = "Asia/Manila";
                                if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
                                $cur_date = date("Y-m-d H:i:s");
                                $date_returned = date("Y-m-d H:i:s");
                            ?>
                            <tr>
                                <td style="text-transform: capitalize">
                                    <?php echo $return_row['firstname']." ".$return_row['lastname']; ?></td>
                                <td style="text-transform: capitalize"><?php echo $return_row['book_title']; ?></td>
                                <!---	<td style="text-transform: capitalize"><?php // echo $return_row['author']; ?></td>
								<td><?php // echo $return_row['isbn']; ?></td>	-->
                                <td><?php echo date("M d, Y h:m:s a",strtotime($return_row['return_request_date'])); ?>
                                </td>

                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="date_returned" class="new_text" id="sd"
                                            value="<?php echo $date_returned ?>" size="16" maxlength="10" />
                                        <input type="hidden" name="user_id"
                                            value="<?php echo $return_row['user_id']; ?>">
                                        <input type="hidden" name="borrow_book_id"
                                            value="<?php echo $return_row['borrow_book_id']; ?>">
                                        <input type="hidden" name="book_id"
                                            value="<?php echo $return_row['book_id']; ?>">
                                        <input type="hidden" name="date_borrowed"
                                            value="<?php echo $return_row['date_borrowed']; ?>">
                                        <input type="hidden" name="due_date"
                                            value="<?php echo $return_row['due_date']; ?>">
                                        <button name="return" class="btn btn-danger"><i
                                                class="glyphicon glyphicon-remove"></i> Return</button>
                                    </form>
                                </td>

                            </tr>

                            <?php 
							}
							if ($return_count <= 0){
								echo '
									<table style="float:right;">
										<tr>
											<td style="padding:10px;" class="alert alert-danger">No Return Books request at this moment</td>
										</tr>
									</table>
								';
							} 							
							?>
                            <?php
								if (isset($_POST['return'])) {
									$user_id= $_POST['user_id'];
									$borrow_book_id= $_POST['borrow_book_id'];
									$book_id= $_POST['book_id'];
									$date_borrowed= $_POST['date_borrowed'];
									$due_date= $_POST['due_date'];
									$date_returned = $_POST['date_returned'];

									$update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
									$copies_row= mysqli_fetch_assoc($update_copies);
									
									$book_copies = $copies_row['book_copies'];
									$new_book_copies = $book_copies + 1;
									
									if ($new_book_copies == '0') {
										$remark = 'Not Available';
									} else {
										$remark = 'Available';
									}
									
									mysqli_query($con,"UPDATE book SET book_copies = '$new_book_copies' where book_id = '$book_id'") or die (mysqli_error());
									mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id' ") or die (mysqli_error());
								
									$timezone = "Asia/Manila";
									if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
									$cur_date = date("Y-m-d H:i:s");
									$date_returned_now = date("Y-m-d H:i:s");		
									
									$penalty_amount_query= mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
									$penalty_amount = mysqli_fetch_assoc($penalty_amount_query);
									
									if ($date_returned > $due_date) {
										$penalty = round((float)(strtotime($date_returned) - strtotime($due_date)) / (60 * 60 *24) * ($penalty_amount['penalty_amount']));
									} elseif ($date_returned < $due_date) {
										$penalty = 'No Penalty';
									} else {
										$penalty = 'No Penalty';
									}
								
									mysqli_query($con,"UPDATE borrow_book SET borrowed_status = 'returned', date_returned = '$date_returned_now', book_penalty = '$penalty' WHERE borrow_book_id= '$borrow_book_id' and user_id = '$user_id' and book_id = '$book_id' ") or die (mysqli_error());
									
									mysqli_query($con,"INSERT INTO return_book (user_id, book_id, date_borrowed, due_date, date_returned, book_penalty)
									values ('$user_id', '$book_id', '$date_borrowed', '$due_date', '$date_returned', '$penalty')") or die (mysqli_error());
									
									$report_history1=mysqli_query($con,"select * from admin where admin_id = $id_session ") or die (mysqli_error());
									$report_history_row1=mysqli_fetch_array($report_history1);
									$admin_row1=$report_history_row1['firstname']." ".$report_history_row1['middlename']." ".$report_history_row1['lastname'];	
									
									mysqli_query($con,"INSERT INTO report 
									(book_id, user_id, admin_name, detail_action, date_transaction)
									VALUES ('$book_id','$user_id','$admin_row1','Returned Book',NOW())") or die(mysqli_error());

                                    mysqli_query($con,"DELETE from return_request where borrow_book_id = '$borrow_book_id' ") or die (mysqli_error());
							?>
                            <script>
                            window.location = "returned_book.php";
                            </script>
                            <?php 
																}
							?>

                        </tbody>
                    </table>
                </div>

                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>