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
            <span class="form-header">MY ISSUED BOOKS</span>
        </div>

        <div class="panel">
            <div class="panel-heading">ISSUED BOOKS LIST</div>
            <div class="panel-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Book Name</th>
                                <th>ISBN</th>
                                <th>Issued Date</th>
                                <th>Return Date</th>
                                <th>Fine (GHS)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sid = $_SESSION['stdid'];
                                $sql = "SELECT tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine,tblissuedbookdetails.ReturnStatus from  tblissuedbookdetails join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where StudentID=:sid order by tblissuedbookdetails.id desc";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { 
                                        // Fine Logic
                                        $fine = "";
                                        if($result->ReturnStatus == 0 || $result->ReturnStatus == NULL) {
                                            $issueDate = $result->IssuesDate;
                                            $dueDate = date('Y-m-d', strtotime($issueDate. ' + 7 days'));
                                            $currentDate = date('Y-m-d');
                                            if($currentDate > $dueDate) {
                                                $diff = abs(strtotime($currentDate) - strtotime($dueDate));
                                                $daysOverdue = floor($diff / (60*60*24));
                                                $fine = $daysOverdue . " GHS (Est)";
                                            }
                                        } else {
                                            $fine = $result->fine . " GHS";
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($result->BookName);?></td>
                                        <td><?php echo htmlentities($result->ISBNNumber);?></td>
                                        <td><?php echo htmlentities($result->IssuesDate);?></td>
                                        <td>
                                            <?php if ($result->ReturnDate == "") { ?>
                                                <span style="color: #e74c3c">Not Returned Yet</span>
                                            <?php } else { ?>
                                                <?php echo htmlentities($result->ReturnDate); ?>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlentities($fine);?></td>
                                    </tr>
                             <?php $cnt++; }
                                } else { ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">No Books Issued</td>
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
