<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:landingpage.php');
} else {
    // Code for Update
    if(isset($_POST['update'])) {
        $sid = $_SESSION['stdid'];
        $fname = $_POST['fullanme'];
        $mobileno = $_POST['mobileno'];
        $email = $_POST['email']; // Assuming we allow email update, or just use as identifier? Based on request "change some information".
        
        $sql = "update tblstudents set FullName=:fname,MobileNumber=:mobileno,EmailId=:email where StudentId=:sid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        
        // Modal Success Feedback
        $msg = "Profile updated successfully!";
        echo "<script>
            window.addEventListener('load', function() {
                showModal('Success', '$msg', 'success');
            });
        </script>";
        // Note: showModal needs to be available in footer or loaded cleanly.
    }
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
             <span class="form-header">MY PROFILE</span>
        </div>

        <div class="panel" style="max-width: 600px;">
            <div class="panel-body">
                <form name="signup" method="post">
                    <?php 
                        $sid = $_SESSION['stdid'];
                        $sql = "SELECT StudentId,FullName,EmailId,MobileNumber,RegDate,Status from tblstudents where StudentId=:sid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) { ?>
                            
                            <div class="form-group">
                                <label>Student ID (Read Only)</label>
                                <input class="form-control" type="text" name="studentId" value="<?php echo htmlentities($result->StudentId);?>" readonly style="background-color: #e9ecef;">
                            </div>

                            <div class="form-group">
                                <label>Registration Date (Read Only)</label>
                                <input class="form-control" type="text" name="regDate" value="<?php echo htmlentities($result->RegDate);?>" readonly style="background-color: #e9ecef;">
                            </div>

                                <div class="form-group">
                                    <label>Profile Status</label>
                                    <?php if($result->Status==1){?>
                                        <span style="color: var(--accent-color); font-weight: bold;">Active</span>
                                    <?php } else {?>
                                        <span style="color: var(--secondary-color); font-weight: bold;">Blocked</span>
                                    <?php }?>
                                </div>


                            <div class="form-group">
                                <label>Full Name</label>
                                <input class="form-control" type="text" name="fullanme" value="<?php echo htmlentities($result->FullName);?>" required>
                            </div>

                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input class="form-control" type="text" name="mobileno" value="<?php echo htmlentities($result->MobileNumber);?>" required>
                            </div>

                            <div class="form-group">
                                <label>Email ID</label>
                                <input class="form-control" type="email" name="email" value="<?php echo htmlentities($result->EmailId);?>" required>
                            </div>

                            <button type="submit" name="update" class="btn btn-info">Update Profile</button>

                    <?php }
                        } ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
<?php } ?>
