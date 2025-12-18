<?php
session_start();
error_reporting(0);
include('../includes/config.php');

// Initialize Modal
$msg_title = "";
$msg_content = "";
$msg_type = "";
$msg_redirect = "";

if (strlen($_SESSION['login']) == 0) {
    header('location:landingpage.php');
} else {
    if(isset($_GET['bookid'])) {
        $bookid = intval($_GET['bookid']);
        $studentid = $_SESSION['stdid'];
        
        // Ensure student hasn't already requested this book and it's pending
        $checkSql = "SELECT id FROM tblrequests WHERE StudentId=:studentid AND BookId=:bookid AND Status=0";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $checkQuery->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $checkQuery->execute();
        
        if($checkQuery->rowCount() > 0) {
             $msg_title = "Already Requested";
             $msg_content = "You have already requested this book and it is pending approval.";
             $msg_type = "info";
             $msg_redirect = "listed-books.php";
        } else {
            $sql = "INSERT INTO tblrequests(StudentId,BookId) VALUES(:studentid,:bookid)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
            $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query->execute();
            
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId) {
                $msg_title = "Request Sent";
                $msg_content = "Book requested successfully. Waiting for Admin approval.";
                $msg_type = "success";
                $msg_redirect = "listed-books.php"; // Redirect back to list
            } else {
                $msg_title = "Error";
                $msg_content = "Something went wrong. Play try again";
                $msg_type = "error";
                $msg_redirect = "listed-books.php";
            }
        }
    }
}
?>
<?php include('../includes/header.php');?>
<!-- Minimal content wrapper to maintain layout structure -->
<div class="content-wrapper" style="min-height: 400px;">
    <div class="container">
        <!-- Content not really needed as modal takes over -->
    </div>
</div>
<?php include('../includes/footer.php');?>
<script>
    <?php if($msg_title != "") { ?>
        showModal('<?php echo $msg_title;?>', '<?php echo $msg_content;?>', '<?php echo $msg_type;?>', '<?php echo $msg_redirect;?>');
    <?php } else { ?>
        // If no logic ran (e.g. no bookid), just redirect back
        window.location.href = 'listed-books.php';
    <?php } ?>
</script>
