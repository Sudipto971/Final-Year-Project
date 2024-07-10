<?php include ('include/header_home.php'); ?>

<div class="page-title">
    <div class="title_left">
        <h3>
            <small>Home /</small> Books
        </h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <!-- content starts here -->

                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                        id="example">

                        <thead>
                            <tr>
                                <th style="width:100px;">Book Image</th>
                                <th>Title</th>
                                <th>ISBN</th>
                                <th>Author</th>
                                <th>Copies</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
							$result= mysqli_query($con,"select * from book order by book_id DESC ") or die (mysqli_error());
							while ($row= mysqli_fetch_array ($result) ){
							$id=$row['book_id'];
							$category_id=$row['category_id'];
							
							$cat_query = mysqli_query($con,"select * from category where category_id = '$category_id'")or die(mysqli_error());
							$cat_row = mysqli_fetch_array($cat_query);
							?>
                            <tr>
                                <td>
                                    <?php if($row['book_image'] != ""): ?>
                                    <img src="upload/<?php echo $row['book_image']; ?>" class="img-thumbnail"
                                        width="75px" height="50px">
                                    <?php else: ?>
                                    <img src="images/book_image.jpg" class="img-thumbnail" width="75px" height="50px">
                                    <?php endif; ?>
                                </td>
                                <td style="word-wrap: break-word; width: 10em;"><?php echo $row['book_title']; ?></td>
                                <td style="word-wrap: break-word; width: 10em;"><?php echo $row['isbn']; ?></td>
                                <td style="word-wrap: break-word; width: 10em;"><?php echo $row['author']; ?></td>
                                <td><?php echo $row['book_copies']; ?></td>
                                <td><?php echo $cat_row['classname']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['remarks']; ?></td>
                                <td>
                                    <a class="btn btn-success"
                                        href="request_borrow.php<?php echo '?book_id='.$row['book_id']; ?>"> Borrow
                                        Request</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include ('footer.php'); ?>