<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Code for blocking/unblocking students could go here if requested later
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        
        <div class="heading">
            <span class="form-header">REGISTERED STUDENTS</span>
        </div>

        <div class="panel">
            <div class="panel-heading">ALL STUDENTS</div>
            <div class="panel-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Full Name</th>
                                <th>Email ID</th>
                                <th>Mobile Number</th>
                                <th>Reg Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT * from tblstudents";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($result->StudentId);?></td>
                                        <td><?php echo htmlentities($result->FullName);?></td>
                                        <td><?php echo htmlentities($result->EmailId);?></td>
                                        <td><?php echo htmlentities($result->MobileNumber);?></td>
                                        <td><?php echo htmlentities($result->RegDate);?></td>
                                        <td>
                                            <?php if($result->Status==1) { ?>
                                                <span style="color: green">Active</span>
                                            <?php } else { ?>
                                                <span style="color: red">Blocked</span>
                                            <?php } ?>
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
