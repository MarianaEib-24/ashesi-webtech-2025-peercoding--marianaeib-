<?php
session_start();
error_reporting(0);
include('../includes/config.php');
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        <div class="heading">
             <span class="form-header">WELCOME TO THE LIBRARY</span>
        </div>
        
        <div class="panel">
            <div class="panel-heading">About Our System</div>
            <div class="panel-body">
                <p style="font-size: 1.1rem; line-height: 1.8; color: #f0f0f0; text-align: center;">
                    Welcome to our state-of-the-art Online Library Management System. 
                    We provide a seamless platform for students and faculty to access vast resources, 
                    manage borrowing, and stay updated with the latest additions to our collection.
                    <br><br>
                    Explore knowledge with ease and efficiency.
                </p>
                <div style="margin-top: 30px; text-align: center;">
                    <a href="landingpage.php" class="btn btn-info" style="display: inline-block; width: auto; min-width: 150px; margin: 10px;">User Login</a>
                    <a href="signup.php" class="btn btn-danger" style="display: inline-block; width: auto; min-width: 150px; margin: 10px;">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
