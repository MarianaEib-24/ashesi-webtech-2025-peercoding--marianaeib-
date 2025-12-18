<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:landingpage.php');
} else {
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <span class="form-header">MY BOOK REQUESTS</span>
        </div>

        <div style="text-align: right; margin-bottom: 20px;">
            <a href="listed-books.php" class="btn btn-info">BROWSE & REQUEST BOOKS</a>
        </div>

        <div class="panel">
            <div class="panel-heading">REQUEST HISTORY</div>
            <div class="panel-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Book Name</th>
                                <th>ISBN</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sid = $_SESSION['stdid'];
                                $sql = "SELECT tblbooks.BookName,tblbooks.ISBNNumber,tblrequests.RequestDate,tblrequests.Status,tblrequests.Remark from  tblrequests join tblbooks on tblbooks.id=tblrequests.BookId where tblrequests.StudentId=:sid order by tblrequests.id desc";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                $cnt=1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($result->BookName);?></td>
                                        <td><?php echo htmlentities($result->ISBNNumber);?></td>
                                        <td><?php echo htmlentities($result->RequestDate);?></td>
                                        <td>
                                            <?php if($result->Status==0){ ?>
                                                <span style="background: #f39c12; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Pending</span>
                                            <?php } else if($result->Status==1) { ?>
                                                <span style="background: #27ae60; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Approved</span>
                                            <?php } else { ?>
                                                <span style="background: #e74c3c; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Declined</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlentities($result->Remark);?></td>
                                    </tr>
                             <?php $cnt++; }
                                } else { ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">No Requests Found</td>
                                    </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
<?php } ?>
