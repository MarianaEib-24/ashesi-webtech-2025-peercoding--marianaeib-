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
            <span class="form-header">ADMIN DASHBOARD</span>
        </div>

        <!-- Dashboard Stats Grid -->
        <div class="dashboard-grid">
            <!-- Books Listed -->
            <?php 
                $sql = "SELECT id from tblbooks";
                $query = $dbh->prepare($sql);
                $query->execute();
                $listdbooks = $query->rowCount();
            ?>
            <a href="manage-books.php" class="stat-card" style="text-decoration:none; display:block; border-left: 5px solid var(--accent-color);">
                <h3 style="color: var(--accent-color);"><?php echo htmlentities($listdbooks);?></h3>
                <p>Books Listed</p>
            </a>

            <!-- Total Issued Books --> 
            <?php 
                $sql1 = "SELECT id from tblissuedbookdetails";
                $query1 = $dbh->prepare($sql1);
                $query1->execute();
                $issuedbooks = $query1->rowCount();
            ?>
             <div class="stat-card" style="border-left-color: #3498db;">
                <h3 style="color: #3498db;"><?php echo htmlentities($issuedbooks);?></h3>
                <p>Times Book Issued</p>
            </div>

            <!-- Books Not Returned Yet -->
            <?php 
                $status = 1;
                $sql2 = "SELECT id from tblissuedbookdetails where ReturnStatus is null || ReturnStatus!=:status";
                $query2 = $dbh->prepare($sql2);
                $query2->bindParam(':status', $status, PDO::PARAM_STR);
                $query2->execute();
                $returnedbooks = $query2->rowCount();
            ?>
            <a href="manage-issued-books.php" class="stat-card danger" style="text-decoration:none; display:block;">
                <h3><?php echo htmlentities($returnedbooks);?></h3>
                <p>Books Not Returned</p>
            </a>

            <!-- Registered Users -->
             <?php 
                $sql3 = "SELECT id from tblstudents";
                $query3 = $dbh->prepare($sql3);
                $query3->execute();
                $regusers = $query3->rowCount();
            ?>
            <a href="reg-students.php" class="stat-card success" style="text-decoration:none; display:block;">
                <h3><?php echo htmlentities($regusers);?></h3>
                <p>Registered Users</p>
            </a>
        </div>

    </div>
</div>

<?php include('../includes/footer.php');?>
<?php } ?>
