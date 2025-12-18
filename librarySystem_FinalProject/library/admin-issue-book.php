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

    if(isset($_POST['issue'])) {
        $studentid = $_POST['studentid'];
        $bookid = $_POST['bookid'];
        
        $remark = "Direct Issue";
        $sql = "INSERT INTO tblissuedbookdetails(StudentID,BookId,remark) VALUES(:studentid,:bookid,:remark)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        
        // Update Book Status to Issued
        $sql2 = "UPDATE tblbooks SET isIssued=1 WHERE id=:bookid";
        $query2 = $dbh->prepare($sql2);
        $query2->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query2->execute();
        
        if($lastInsertId) {
            $msg_title = "Success";
            $msg_content = "Book Issued Successfully";
            $msg_type = "success";
            $msg_redirect = "manage-issued-books.php";
        } else {
            $msg_title = "Error";
            $msg_content = "Something went wrong. Please try again";
            $msg_type = "error";
        }
    }
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <span class="form-header">ISSUE A NEW BOOK</span>
        </div>

        <div class="panel" style="max-width: 600px;">
            <div class="panel-heading">ISSUE BOOK</div>
            <div class="panel-body">
                <form method="post">
                    
                    <div class="form-group">
                        <label>Student</label>
                        <select class="form-control" name="studentid" required>
                            <option value="">Select Student</option>
                            <?php 
                                $sql = "SELECT StudentId,FullName from tblstudents where Status=1";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) { ?>
                                        <option value="<?php echo htmlentities($result->StudentId);?>"><?php echo htmlentities($result->FullName)." (".$result->StudentId.")";?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Book (ISBN - Title)</label>
                        <select class="form-control" name="bookid" required>
                            <option value="">Select Book</option>
                            <?php 
                                $sql = "SELECT id,BookName,ISBNNumber from tblbooks";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) { ?>
                                        <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->ISBNNumber)." - ".htmlentities($result->BookName);?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <button type="submit" name="issue" class="btn btn-info">ISSUE BOOK</button>
                    
                </form>
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
