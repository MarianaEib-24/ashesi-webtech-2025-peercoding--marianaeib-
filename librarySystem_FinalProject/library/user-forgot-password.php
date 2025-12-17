<?php
session_start();
error_reporting(0);
include('../includes/config.php');

$msg_title = "";
$msg_content = "";
$msg_type = "";

if(isset($_POST['change']))
{
  $email=$_POST['email'];
  $mobile=$_POST['mobile'];
  $newpassword=md5($_POST['newpassword']);
  $sql ="SELECT EmailId FROM tblstudents WHERE EmailId=:email and MobileNumber=:mobile";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':email', $email, PDO::PARAM_STR);
  $query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
  $query-> execute();
  $results = $query -> fetchAll(PDO::FETCH_OBJ);
  if($query -> rowCount() > 0)
  {
    $con="update tblstudents set Password=:newpassword where EmailId=:email and MobileNumber=:mobile";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
    $chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    
    $msg_title = "Success!";
    $msg_content = "Your Password has been successfully changed.";
    $msg_type = "success";
  }
  else {
    $msg_title = "Invalid Details";
    $msg_content = "Email ID or Mobile Number is invalid/not found.";
    $msg_type = "error";
  }
}
?>

<?php include('../includes/header.php');?>

    <div class="content-wrapper">
        <div class="container">
            <div class="heading">
                <span class="form-header">RECOVER PASSWORD</span>
            </div>
             
            <div class="panel panel-info">
                <div class="panel-heading">PASSWORD RECOVERY</div>
                <div class="panel-body">
                    <form role="form" name="chngpwd" method="post" onSubmit="return valid();">
                        <div class="form-group">
                            <label>Registered Email</label>
                            <input class="form-control" type="email" name="email" required autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label>Registered Mobile No</label>
                            <input class="form-control" type="text" name="mobile" required autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control" type="password" name="newpassword" required autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input class="form-control" type="password" name="confirmpassword" required autocomplete="off" />
                        </div>

                        <button type="submit" name="change" class="btn btn-info">Change Password</button> 
                        <p style="text-align: center; margin-top: 15px;">
                            <a href="landingpage.php">Back to Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php');?>

    <script type="text/javascript">
        // Trigger Modal from PHP logic
        <?php if($msg_title != "") { ?>
            showModal('<?php echo $msg_title;?>', '<?php echo $msg_content;?>', '<?php echo $msg_type;?>'<?php if($msg_type == 'success') echo ", 'landingpage.php'"; ?>);
        <?php } ?>

        function valid()
        {
            if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
            {
                showModal('Mismatch', 'New Password and Confirm Password Field do not match!', 'error');
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
