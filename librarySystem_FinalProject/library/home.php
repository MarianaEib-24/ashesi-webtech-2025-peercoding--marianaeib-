<?php
session_start();
error_reporting(0);
include('../includes/config.php');
?>
<?php include('../includes/header.php');?>

<div class="content-wrapper">
    <div class="container">
        
        <!-- Slideshow Section: corrected paths and structure -->
        <section class="image-box slideshow-container">
            <img class="mySlides" src="1.jpg">
            <img class="mySlides" src="2.jpg">
            <img class="mySlides" src="3.jpg">
        </section>

        <div class="heading">
             <span class="form-header">WELCOME TO THE LIBRARY</span>
        </div>
        
        <div class="panel">
            <div class="panel-heading">About Our System</div>
            <div class="panel-body">
                <p style="font-size: 1.1rem; line-height: 1.8; color: #2C3E50; text-align: center;">
                    Welcome to our Online Library Management System. 
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

<!-- Added Missing JavaScript for Slideshow -->
<script>
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
