<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if ($_SESSION['login'] != '') {
    $_SESSION['login'] = '';
}

// Variables for Modal
$msg_title = "";
$msg_content = "";
$msg_type = "";

if (isset($_POST['login'])) {

    $email = $_POST['emailid'];
    $password = md5($_POST['password']);
    $sql = "SELECT EmailId,Password,StudentId,Status FROM tblstudents WHERE EmailId=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['stdid'] = $result->StudentId;
            if ($result->Status == 1) {
                $_SESSION['login'] = $_POST['emailid'];
                echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
            } else {
                $msg_title = "Account Blocked";
                $msg_content = "Your Account has been blocked. Please contact admin.";
                $msg_type = "error";
            }
        }
    } else {
        $msg_title = "Login Failed";
        $msg_content = "Invalid Details"; // Changed to match user request "Invalid Details"
        $msg_type = "error";
    }
}
?>

<?php include('../includes/header.php');?>

    <div class="content-wrapper">
        <div class="container">
            <section class="image-box slideshow-container">
                <img class="mySlides" src="1.jpg">
                <img class="mySlides" src="2.jpg">
                <img class="mySlides" src="3.jpg">
            </section>

            <div class="panel panel-info panel-auth">
                <div class="panel-heading">LOGIN FORM</div>
                <div class="panel-body">
                    <form role="form" method="post">
                        <div class="form-group">
                            <label>Enter Email</label>
                            <input class="form-control" type="text" name="emailid" required="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" required="" autocomplete="off">
                        </div>
                        <p class="help-block"><a href="user-forgot-password.php">Forgot Password?</a></p>
                        <button type="submit" name="login" class="btn btn-info">LOGIN</button>
                        <p style="text-align: center; margin-top: 15px;">
                            <a href="signup.php" style="font-size: 0.9em;">Not Registered Yet? Sign Up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php');?>
    
    <script>
        // Trigger Modal from PHP logic
        <?php if($msg_title != "") { ?>
            showModal('<?php echo $msg_title;?>', '<?php echo $msg_content;?>', '<?php echo $msg_type;?>');
        <?php } ?>

        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 3000); // Change image every 3 seconds
        }
    </script>