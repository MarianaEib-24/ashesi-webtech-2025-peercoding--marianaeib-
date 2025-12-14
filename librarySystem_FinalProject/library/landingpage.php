<?php
session_start();
error_reporting(0);
include('includes/config.php');
if ($_SESSION['login'] != '') {
    $_SESSION['login'] = '';
}
if (isset($_POST['login'])) {

    $email = $_POST['emailid'];
    $password = md5($_POST['password']);
    $sql = "SELECT EmailId,Password,StudentId,Status FROM tblstudents WHERE EmailId=:email and Password=:password";
    $query = $dbh->prepare($sql); //prepare the sql query to be sent 
    $query->bindParam(':email', $email, PDO::PARAM_STR); //binds the place holder to the parameter
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute(); // runs the query against the database
    $results = $query->fetchAll(PDO::FETCH_OBJ); //retireve all matching rows as objects 

    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['stdid'] = $result->StudentId;
            if ($result->Status == 1) {
                $_SESSION['login'] = $_POST['emailid'];
                echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
            } else {
                echo "<script>alert('Your Account Has been blocked .Please contact admin');</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <!-- <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <!-- <link href="assets/css/font-awesome.css" rel="stylesheet" /> -->
    <!-- CUSTOM STYLE  -->
    <link rel="stylesheet" href="style.css" />
    <!-- GOOGLE FONT -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> -->

</head>

<body>
    <div>
        <a class="navbar-brand">
            <img src="logo.png">
        </a>
    </div>
    <div>
        <section class="menu-section">
            <div class="right-div">
                <ul>
                    <li>
                        <a href="home.php">HOME</a>
                    </li>
                    <li>
                        <a href="home.php">USER SIGNUP</a>
                    </li>
                    <li>
                        <a href="home.php">USER LOGIN</a>
                    </li>
                    <li>
                        <a href="home.php">ADMIN LOGIN</a>
                    </li>
                </ul>
            </div>
        </section>
    </div>

    <div class="container">
        <section class="image-box">
            <img src="1.jpg">
        </section>
    </div>
    <div class="heading">
        <hr style="height:2px;border-width:0;color:#B7B5;background-color:#005461;width:80%;">
        <span class="form-header">USER LOGIN</span>
        <hr style="height:2px;border-width:0;color:#B7B5;background-color:#005461;width:80%;">
    </div>
    <div class="panel panel-info">
        <!-- <div class="panel-info"> -->
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
                    <p class="help-block"><a href="user-forgot-password.php">Forgot Password</a></p>
                </div>
            </form>
        </div>
        <!-- </div> -->
    </div>

</body>

</html>