<?php include ('include/header_home.php'); ?>

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
                            where user.user_id = '$user_session'
							$where") or die (mysqli_error($con));
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
?>
                            <tr>
                                <td style="text-transform: capitalize">
                                    <?php echo $return_row['firstname']." ".$return_row['lastname']; ?></td>
                                <td style="text-transform: capitalize"><?php echo $return_row['book_title']; ?></td>
                                <!---	<td style="text-transform: capitalize"><?php // echo $return_row['author']; ?></td>
								<td><?php // echo $return_row['isbn']; ?></td>	-->
                                <td><?php echo date("M d, Y h:m:s a",strtotime($return_row['return_request_date'])); ?>
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
                        </tbody>
                    </table>
                </div>

                <!-- content ends here -->
            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>