<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        
        <div class="heading">
            <span class="form-header">MANAGE ISSUED BOOKS</span>
        </div>
        
        <div style="text-align: right; margin-bottom: 20px;">
            <a href="admin-issue-book.php" class="btn btn-info">ISSUE NEW BOOK</a>
        </div>

        <div class="panel">
            <div class="panel-heading">ALL ISSUED BOOKS</div>
            <div class="panel-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Book Name</th>
                                <th>ISBN</th>
                                <th>Issued Date</th>
                                <th>Return Date</th>
                                <th>Fine</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine,tblissuedbookdetails.ReturnStatus from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId order by tblissuedbookdetails.id desc";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                $cnt=1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { 
                                        // Fine Calculation Logic (Same as Dashboard but can be more specific here)
                                        $fine = "";
                                        if($result->ReturnStatus == 0 || $result->ReturnStatus == NULL) {
                                            // Active Loan
                                            $issueDate = $result->IssuesDate;
                                            $dueDate = date('Y-m-d', strtotime($issueDate. ' + 7 days'));
                                            $currentDate = date('Y-m-d');
                                            if($currentDate > $dueDate) {
                                                $diff = abs(strtotime($currentDate) - strtotime($dueDate));
                                                $daysOverdue = floor($diff / (60*60*24));
                                                $fine = $daysOverdue . " GHS (Est)";
                                            }
                                        } else {
                                            // Returned
                                            $fine = $result->fine;
                                        }
                            ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($result->FullName);?></td>
                                        <td><?php echo htmlentities($result->BookName);?></td>
                                        <td><?php echo htmlentities($result->ISBNNumber);?></td>
                                        <td><?php echo htmlentities($result->IssuesDate);?></td>
                                        <td><?php if ($result->ReturnDate == "") { echo '<span style="color: #e74c3c">Not Returned Yet</span>'; } else { echo htmlentities($result->ReturnDate); } ?></td>
                                        <td><?php echo htmlentities($fine);?></td>
                                        <td>
                                            <a href="edit-issue-book.php?rid=<?php echo htmlentities($result->rid);?>" class="btn btn-info" style="padding: 5px 10px; font-size: 0.8rem; height: auto; margin:0;">Edit</a>
                                        </td>
                                    </tr>
                             <?php $cnt++; }
                                } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include('../includes/footer.php');?>
<?php } ?>
