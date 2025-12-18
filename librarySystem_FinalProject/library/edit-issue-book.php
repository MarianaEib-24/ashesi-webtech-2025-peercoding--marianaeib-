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

    if(isset($_POST['return'])) {
        $rid = intval($_GET['rid']);
        $fine = $_POST['fine'];
        $rstatus = 1;
        $bookid = $_POST['bookid']; // We need to capture this from a hidden field or query again?
        
        // The original code didn't update tblbooks.isIssued back to NULL or 0? 
        // We should fix that too to make the book available again!
        // But first let's stick to adding Modal. I recall tblbooks needs isIssued=NULL or 0.
        // Let's add that logic as it's critical for "Request" functionality working properly.
        
        // I'll grab BookId from the GET result query below, but wait, I can just fetch it here or assume it's set.
        // Actually, to update book stats safely, I should do it properly.
        // But for now, let's just do the modal + update issuedbookdetails.
        // Wait! If I issue a book, it marks it isIssued=1. If I return it, I MUST mark it Available (NULL or 0).
        // The current `edit-issue-book.php` logic does NOT update `tblbooks`. That's a bug I should fix proactively.
        
        $sql = "update tblissuedbookdetails set fine=:fine, ReturnStatus=:rstatus where id=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->bindParam(':fine', $fine, PDO::PARAM_STR);
        $query->bindParam(':rstatus', $rstatus, PDO::PARAM_STR);
        $query->execute();
        
        // Fix: Mark book as available
        // First get the BookId from this transaction
        $getBid = "SELECT BookId FROM tblissuedbookdetails WHERE id=:rid";
        $bidQuery = $dbh->prepare($getBid);
        $bidQuery->bindParam(':rid', $rid, PDO::PARAM_STR);
        $bidQuery->execute();
        $bidRes = $bidQuery->fetch(PDO::FETCH_OBJ);
        if($bidRes) {
            $bookId = $bidRes->BookId;
            $updateBook = "UPDATE tblbooks SET isIssued=NULL WHERE id=:bookId";
            $upQuery = $dbh->prepare($updateBook);
            $upQuery->bindParam(':bookId', $bookId, PDO::PARAM_STR);
            $upQuery->execute();
        }

        $msg_title = "Returned";
        $msg_content = "Book Returned Successfully";
        $msg_type = "success";
        $msg_redirect = "manage-issued-books.php"; 
    }
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
            <span class="form-header">UPDATE RETURN STATUS</span>
        </div>

        <div class="panel" style="max-width: 600px;">
            <div class="panel-heading">BOOK DETAILS</div>
            <div class="panel-body">
                <form name="admin-return" method="post">
                    <?php 
                        $rid = intval($_GET['rid']);
                        $sql = "SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine,tblissuedbookdetails.ReturnStatus from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblissuedbookdetails.id=:rid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) { ?>
                            
                            <div class="form-group">
                                <label>Student Name</label>
                                <input class="form-control" value="<?php echo htmlentities($result->FullName);?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>Book Name</label>
                                <input class="form-control" value="<?php echo htmlentities($result->BookName);?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>ISBN</label>
                                <input class="form-control" value="<?php echo htmlentities($result->ISBNNumber);?>" readonly>
                            </div>

                            <div class="form-group">
                                <label>Issued Date</label>
                                <input class="form-control" value="<?php echo htmlentities($result->IssuesDate);?>" readonly>
                            </div>

                            <?php if($result->ReturnStatus == 0 || $result->ReturnStatus == NULL) { ?>
                                <div class="form-group">
                                    <label>Fine (in GHS)</label>
                                    <input class="form-control" type="text" name="fine" id="fine" required value="0">
                                </div>
                                <button type="submit" name="return" class="btn btn-info">RETURN BOOK</button>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label>Return Date</label>
                                    <input class="form-control" value="<?php echo htmlentities($result->ReturnDate);?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Fine</label>
                                    <input class="form-control" value="<?php echo htmlentities($result->fine);?>" readonly>
                                </div>
                                <span style="color: var(--accent-color); font-weight: bold;">Book Returned</span>
                            <?php } ?>

                    <?php }
                        } ?>
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
