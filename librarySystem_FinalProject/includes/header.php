<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Online Library Management System" />
    <meta name="author" content="" />
    <title>Online Library Management System</title>
    <!-- CUSTOM STYLE  -->
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <!-- Ensure logo path is correct relative to includes -->
            <img src="logo.png" alt="Library Logo" style="height: 40px; display: none;"> <!-- Placeholder if no logo -->
            <span style="color: white; font-size: 1.5rem; font-weight: bold; letter-spacing: 1px;">Online Library Management System</span>
        </div>
        <div class="menu-section">
            <ul>
                <?php if(isset($_SESSION['login']) && $_SESSION['login'] != '') { ?>
                    <!-- Logged In User Menu -->
                    <li><a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">DASHBOARD</a></li>
                    <li><a href="issued-books.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'issued-books.php' ? 'active' : ''; ?>">ISSUED BOOKS</a></li>
                    <li><a href="my-requests.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'my-requests.php' ? 'active' : ''; ?>">MY REQUESTS</a></li>
                    
                    <li class="dropdown">
                        <a href="#" style="cursor: pointer;">ACCOUNT ▾</a>
                        <div class="dropdown-content">
                            <a href="user-profile.php">My Profile</a>
                        </div>
                    </li>
                    
                    <li><a href="logout.php" class="btn-logout">LOG ME OUT</a></li>
                <?php } else if(isset($_SESSION['alogin']) && $_SESSION['alogin'] != '') { ?>
                    <!-- Admin Menu -->
                    <li><a href="admin-dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php' ? 'active' : ''; ?>">DASHBOARD</a></li>
                    
                    <li class="dropdown">
                        <a href="#" style="cursor: pointer;">BOOKS ▾</a>
                        <div class="dropdown-content">
                            <a href="add-book.php">Add Book</a>
                            <a href="manage-books.php">Manage Books</a>
                        </div>
                    </li>

                    <li><a href="manage-issued-books.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'manage-issued-books.php' ? 'active' : ''; ?>">ISSUED BOOKS</a></li>
                    <li><a href="admin-requests.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin-requests.php' ? 'active' : ''; ?>">REQUESTS</a></li>

                    
                    <li><a href="admin-logout.php" class="btn-logout">LOGOUT</a></li>
                <?php } else { ?>
                    <!-- Guest Menu -->
                    <li><a href="home.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">HOME</a></li>
                    <li><a href="landingpage.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'landingpage.php' ? 'active' : ''; ?>">USER LOGIN</a></li>
                    <li><a href="signup.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'signup.php' ? 'active' : ''; ?>">USER SIGNUP</a></li>
                    <li><a href="admin-login.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin-login.php' ? 'active' : ''; ?>">ADMIN LOGIN</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>
