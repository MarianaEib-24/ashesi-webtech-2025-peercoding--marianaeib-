<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:landingpage.php');
} else {
    $sid = $_SESSION['stdid'];
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        
        <div class="heading">
            <?php
                $sid = $_SESSION['stdid'];
                $sql_name = "SELECT FullName FROM tblstudents WHERE StudentId=:sid";
                $query_name = $dbh->prepare($sql_name);
                $query_name->bindParam(':sid', $sid, PDO::PARAM_STR);
                $query_name->execute();
                $result_name = $query_name->fetch(PDO::FETCH_OBJ);
                $studentName = $result_name->FullName;
            ?>
            <span class="form-header">WELCOME, <?php echo htmlentities(strtoupper($studentName)); ?></span>
        </div>

        <!-- Dashboard Stats Grid -->
        <div class="dashboard-grid">
            <!-- Books Listed (Catalog) -->
            <?php 
                $sql = "SELECT id from tblbooks";
                $query = $dbh->prepare($sql);
                $query->execute();
                $listdbooks = $query->rowCount();
            ?>
            <a href="listed-books.php" class="stat-card" style="text-decoration:none; display:block; border-left: 5px solid var(--accent-color);">
                <h3 style="color: var(--accent-color);"><?php echo htmlentities($listdbooks);?></h3>
                <p>Books Listed</p>
            </a>

            <!-- Books Borrowed (Active) -->
            <?php 
                $rsts = 0;
                $sql2 = "SELECT id from tblissuedbookdetails where StudentID=:sid and (ReturnStatus=:rsts OR ReturnStatus IS NULL || ReturnStatus='')";
                $query2 = $dbh->prepare($sql2);
                $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
                $query2->bindParam(':rsts', $rsts, PDO::PARAM_STR);
                $query2->execute();
                $borrowedBooks = $query2->rowCount();
            ?>
            <div class="stat-card danger">
                <h3><?php echo htmlentities($borrowedBooks);?></h3>
                <p>Books Borrowed</p>
            </div>

            <!-- Books Returned -->
            <?php 
                $rsts_ret = 1;
                $sql3 = "SELECT id from tblissuedbookdetails where StudentID=:sid and ReturnStatus=:rsts";
                $query3 = $dbh->prepare($sql3);
                $query3->bindParam(':sid', $sid, PDO::PARAM_STR);
                $query3->bindParam(':rsts', $rsts_ret, PDO::PARAM_STR);
                $query3->execute();
                $returnedBooks = $query3->rowCount();
            ?>
            <div class="stat-card success">
                <h3><?php echo htmlentities($returnedBooks);?></h3>
                <p>Books Returned</p>
            </div>

            <!-- Total Fines -->
            <?php 
                $totalFine = 0;
                $sql4 = "SELECT IssuesDate, ReturnDate, ReturnStatus, fine from tblissuedbookdetails where StudentID=:sid";
                $query4 = $dbh->prepare($sql4);
                $query4->bindParam(':sid', $sid, PDO::PARAM_STR);
                $query4->execute();
                $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                
                if($query4->rowCount() > 0){
                    foreach($results4 as $row){
                        // Add existing fines from DB
                        if($row->fine != NULL){
                            $totalFine += $row->fine;
                        }

                        // Calculate estimated fine for active overdue books
                        if($row->ReturnStatus == 0 || $row->ReturnStatus == NULL){
                            $issueDate = $row->IssuesDate;
                            $dueDate = date('Y-m-d', strtotime($issueDate. ' + 7 days'));
                            $currentDate = date('Y-m-d');

                            if($currentDate > $dueDate){
                                // Calculate days overdue
                                $diff = abs(strtotime($currentDate) - strtotime($dueDate));
                                $daysOverdue = floor($diff / (60*60*24));
                                // Assume $1 fine per day
                                $totalFine += ($daysOverdue * 1);
                            }
                        }
                    }
                }
            ?>
            <div class="stat-card" style="border-left-color: #f39c12;">
                <h3 style="color: #f39c12;"><?php echo htmlentities($totalFine);?></h3>
                <p>Total Fines (GHS)</p>
            </div>
        </div>

        <div class="panel">
            <div class="panel-heading">RECENT ACTIVITY</div>
            <div class="panel-body" style="padding: 0;">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Issued Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql = "SELECT tblbooks.BookName,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.ReturnStatus,tblissuedbookdetails.id as rid from tblissuedbookdetails join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblissuedbookdetails.StudentID=:sid order by tblissuedbookdetails.id desc limit 5";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>
                                <tr>
                                    <td style="font-weight: 500; color: #3498db;"><?php echo htmlentities($result->BookName);?></td>
                                    <td><?php echo htmlentities($result->IssuesDate);?></td>
                                    <td><?php if ($result->ReturnDate == "") { echo '<span style="color: #e74c3c">Not Returned Yet</span>'; } else { echo htmlentities($result->ReturnDate); } ?></td>
                                    <td>
                                        <?php if ($result->ReturnStatus == 1) {
                                            echo '<span style="color: var(--accent-color); font-weight: bold;">Returned</span>';
                                        } else {
                                            echo '<span style="color: var(--secondary-color); font-weight: bold;">Issued</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                         <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; color: #7f8c8d;">No recent activity found.</td>
                                </tr>
                         <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Requests Section -->
        <div class="panel" style="margin-top: 30px;">
            <div class="panel-heading">RECENT REQUESTS</div>
            <div class="panel-body" style="padding: 0;">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Request Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql_req = "SELECT tblbooks.BookName,tblrequests.RequestDate,tblrequests.Status from tblrequests join tblbooks on tblbooks.id=tblrequests.BookId where tblrequests.StudentId=:sid order by tblrequests.id desc limit 5";
                            $query_req = $dbh->prepare($sql_req);
                            $query_req->bindParam(':sid', $sid, PDO::PARAM_STR);
                            $query_req->execute();
                            $results_req = $query_req->fetchAll(PDO::FETCH_OBJ);
                            if ($query_req->rowCount() > 0) {
                                foreach ($results_req as $res) { ?>
                                <tr>
                                    <td><?php echo htmlentities($res->BookName);?></td>
                                    <td><?php echo htmlentities($res->RequestDate);?></td>
                                    <td>
                                        <?php if($res->Status==0){ ?>
                                            <span style="background: #f39c12; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Pending</span>
                                        <?php } else if($res->Status==1) { ?>
                                            <span style="background: #27ae60; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Approved</span>
                                        <?php } else { ?>
                                            <span style="background: #e74c3c; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.8rem;">Declined</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } 
                            } else { ?>
                                <tr><td colspan="3" style="text-align: center;">No Recent Requests</td></tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include('../includes/footer.php');?>
<?php } ?>
