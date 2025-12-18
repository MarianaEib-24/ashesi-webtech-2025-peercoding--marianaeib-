<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if(isset($_POST['signup'])) {
    $fname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    // check if username already exists
    $sql = "SELECT UserName FROM admin WHERE UserName=:username";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    
    if($query->rowCount() > 0) {
        echo "<script>alert('Username already exists. Please try another one.');</script>";
    } else {
        $sql = "INSERT INTO admin(FullName,AdminEmail,UserName,Password) VALUES(:fname,:email,:username,:password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            echo "<script>alert('Registration Successful. You can now login.'); window.location.href='admin-login.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
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
            <span class="form-header">ADMIN REGISTRATION FORM</span>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">SIGNUP FORM</div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="form-control" type="text" name="fullname" required autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label>Admin Email</label>
                        <input class="form-control" type="email" name="email" required autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" name="username" required autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" required autocomplete="off" />
                    </div>
                    
                    <button type="submit" name="signup" class="btn btn-info">REGISTER</button>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="admin-login.php" style="font-size: 0.9rem;">Already Registered? Login Here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>

<script>
    // slideshow logic
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
        setTimeout(showSlides, 3000); 
    }
</script>
