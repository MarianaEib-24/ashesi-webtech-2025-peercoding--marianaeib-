<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if ($_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}

// Initialize Modal Vars
$msg_title = "";
$msg_content = "";
$msg_type = "";

if (isset($_POST['login'])) {
    
    // Admin Login Logic matching the user's style
    $username = $_POST['username'];
    // $password = $_POST['password'];
    $password = md5($_POST['password']);

    
    $sql = "SELECT UserName,Password FROM admin WHERE UserName=:username and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    if ($query->rowCount() > 0) {
        $_SESSION['alogin'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location ='admin-dashboard.php'; </script>";
    } else {
        $msg_title = "Access Denied";
        $msg_content = "Invalid Username or Password.";
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

        <div class="heading">
            <span class="form-header">ADMIN LOGIN FORM</span>
        </div>

        <div class="panel panel-info panel-auth">
            <div class="panel-heading">LOGIN FORM</div>
            <div class="panel-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label>Enter Username</label>
                        <input class="form-control" type="text" name="username" required autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" required autocomplete="off" />
                    </div>
                    <button type="submit" name="login" class="btn btn-info">LOGIN</button>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="admin-signup.php" style="font-size: 0.9rem;">Not Registered Yet? Signup Here</a>
                    </div>
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

    // Slideshow Logic
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
