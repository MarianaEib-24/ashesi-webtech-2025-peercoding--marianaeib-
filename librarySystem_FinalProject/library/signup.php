<?php
session_start();
error_reporting(0);
include('../includes/config.php');

// Initialize Modal Variables
$msg_title = "";
$msg_content = "";
$msg_type = "";

if (isset($_POST['signup'])) {
    // Signup Logic Placeholder
    // Example: If successful
    // $msg_title = "Success!";
    // $msg_content = "You are successfully registered.";
    // $msg_type = "success";
}
?>

<?php include('../includes/header.php');?>

    <div class="content-wrapper">
        <div class="container">
            <div class="heading">
                <span class="form-header">JOIN OUR LIBRARY</span>
            </div>
            <div class="panel panel-danger">
                <div class="panel-heading">SIGNUP FORM</div>
                <div class="panel-body">
                    <form role="form" method="post" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label>Enter Full Name</label>
                            <input class="form-control" type="text" name="fullname" id="fullname" required="" autocomplete="off">
                            <span id="nameError" class="error-text"></span>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input class="form-control" type="text" name="mobileno" id="mobileno" required="" autocomplete="off">
                            <span id="mobileError" class="error-text"></span>
                        </div>
                        <div class="form-group">
                            <label>Enter Email</label>
                            <input class="form-control" type="email" name="email" id="email" required="" autocomplete="off">
                            <span id="emailError" class="error-text"></span>
                        </div>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <div style="position: relative;">
                                <input class="form-control" type="password" name="password" id="password" required="" autocomplete="off" onkeyup="checkStrength()">
                                <span class="password-toggle" onclick="togglePassword('password')">Show</span>
                            </div>
                            <div class="strength-bar-container">
                                <div id="strength-bar" class="strength-bar"></div>
                            </div>
                            <span id="strength-text" style="font-size: 12px; float: right; margin-top: 5px;"></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <div style="position: relative;">
                                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" required="" autocomplete="off">
                                <span class="password-toggle" onclick="togglePassword('confirmpassword')">Show</span>
                            </div>
                            <span id="confirmError" class="error-text"></span>
                        </div>
                        <button type="submit" name="signup" class="btn btn-danger">Register Now</button>
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

        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                // Optionally change text to "Hide"
            } else {
                field.type = "password";
            }
        }

        function checkStrength() {
            var password = document.getElementById('password').value;
            var strengthBar = document.getElementById('strength-bar');
            var strengthText = document.getElementById('strength-text');
            var strength = 0;

            if (password.length > 7) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[\W]+/)) strength += 1;

            switch (strength) {
                case 0:
                case 1:
                case 2:
                    strengthBar.style.width = '30%';
                    strengthBar.style.backgroundColor = '#d9534f';
                    strengthText.innerHTML = "Weak";
                    strengthText.style.color = "#d9534f";
                    break;
                case 3:
                case 4:
                    strengthBar.style.width = '60%';
                    strengthBar.style.backgroundColor = '#f0ad4e';
                    strengthText.innerHTML = "Medium";
                    strengthText.style.color = "#f0ad4e";
                    break;
                case 5:
                    strengthBar.style.width = '100%';
                    strengthBar.style.backgroundColor = '#5cb85c';
                    strengthText.innerHTML = "Strong";
                    strengthText.style.color = "#5cb85c";
                    break;
            }
        }

        function validateForm() {
            var isValid = true;
            
            // Re-using exiting regex checks but potentially showing Modal for block errors IF desired
            // For inline errors, existing spans are fine.
            
            var name = document.getElementById('fullname').value;
            if (!/^[a-zA-Z\s]+$/.test(name)) {
                document.getElementById('nameError').innerText = "Name must contain only letters and spaces.";
                isValid = false;
            } else { document.getElementById('nameError').innerText = ""; }

            var mobile = document.getElementById('mobileno').value;
            if (!/^[0-9]{10}$/.test(mobile)) {
                document.getElementById('mobileError').innerText = "Mobile number must be 10 digits.";
                isValid = false;
            } else { document.getElementById('mobileError').innerText = ""; }

            var email = document.getElementById('email').value;
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('emailError').innerText = "Invalid email format.";
                isValid = false;
            } else { document.getElementById('emailError').innerText = ""; }

            var pass = document.getElementById('password').value;
            var confirmPass = document.getElementById('confirmpassword').value;
            if (pass !== confirmPass) {
                document.getElementById('confirmError').innerText = "Passwords do not match.";
                isValid = false;
            } else { document.getElementById('confirmError').innerText = ""; }
            
            if (!isValid) {
                 // Optional: Also shake the form or show a modal summary
                 // showModal('Error', 'Please correct the highlighted errors.', 'error');
            }

            return isValid;
        }
    </script>
