<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Initialize Modal
    $msg_title = "";
    $msg_content = "";
    $msg_type = "";
    $msg_redirect = "";

    // Approve Request
    if(isset($_GET['approve'])) {
        $id = $_GET['approve'];
        $studentid = $_GET['sid'];
        $bookid = $_GET['bid'];
        
        // 1. Add to Issued Details
        $remark = "Request Approved";
        $sql = "INSERT INTO tblissuedbookdetails(StudentID,BookId,remark) VALUES(:studentid,:bookid,:remark)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->execute();
        
        // 2. Update Book Status to Issued
        $sql2 = "UPDATE tblbooks SET isIssued=1 WHERE id=:bookid";
        $query2 = $dbh->prepare($sql2);
        $query2->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query2->execute();

        // 3. Update Request Status to Approved (1)
        $sql3 = "UPDATE tblrequests SET Status=1, Remark='Approved' WHERE id=:id";
        $query3 = $dbh->prepare($sql3);
        $query3->bindParam(':id', $id, PDO::PARAM_STR);
        $query3->execute();

        $msg_title = "Approved";
        $msg_content = "Request Approved successfully";
        $msg_type = "success";
        $msg_redirect = "admin-requests.php";
    }

    // Decline Request
    if(isset($_GET['decline'])) {
        $id = $_GET['decline'];
        $sql = "UPDATE tblrequests SET Status=2, Remark='Declined' WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        
        $msg_title = "Declined";
        $msg_content = "Request Declined successfully";
        $msg_type = "error"; // using error style for decline/red
        $msg_redirect = "admin-requests.php";
    }
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <span class="form-header">BOOK REQUESTS INBOX</span>
        </div>

        <div class="panel">
            <div class="panel-heading">PENDING REQUESTS</div>
            <div class="panel-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Book Name</th>
                                <th>ISBN</th>
                                <th>Request Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $status=0;
                                $sql = "SELECT tblstudents.FullName,tblstudents.StudentId,tblbooks.BookName,tblbooks.ISBNNumber,tblrequests.RequestDate,tblrequests.id as rid,tblrequests.BookId from  tblrequests join tblstudents on tblstudents.StudentId=tblrequests.StudentId join tblbooks on tblbooks.id=tblrequests.BookId where tblrequests.Status=:status";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':status', $status, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                $cnt=1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($result->StudentId);?></td>
                                        <td><?php echo htmlentities($result->FullName);?></td>
                                        <td><?php echo htmlentities($result->BookName);?></td>
                                        <td><?php echo htmlentities($result->ISBNNumber);?></td>
                                        <td><?php echo htmlentities($result->RequestDate);?></td>
                                        <td>
                                            <a href="admin-requests.php?approve=<?php echo htmlentities($result->rid);?>&sid=<?php echo htmlentities($result->StudentId);?>&bid=<?php echo htmlentities($result->BookId);?>" onclick="return confirm('Approve this request?');" class="btn btn-success" style="padding: 5px 10px; font-size: 0.8rem; height: auto; margin:0;">Approve</a>
                                            <a href="admin-requests.php?decline=<?php echo htmlentities($result->rid);?>" onclick="return confirm('Decline this request?');" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem; height: auto; margin:0;">Decline</a>
                                        </td>
                                    </tr>
                             <?php $cnt++; }
                                } else { ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No Pending Requests</td>
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
<script>
    <?php if($msg_title != "") { ?>
        showModal('<?php echo $msg_title;?>', '<?php echo $msg_content;?>', '<?php echo $msg_type;?>', '<?php echo $msg_redirect;?>');
    <?php } ?>
</script>
<?php } ?>
