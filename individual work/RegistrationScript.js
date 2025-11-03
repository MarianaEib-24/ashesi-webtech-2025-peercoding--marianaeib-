const registerBtn = document.getElementById("registerBtn");

function goToLogin() {
    window.location.href = "LoginPage.html";
}

registerBtn.addEventListener("click", () => {
  const username = document.getElementById("reg-username").value.trim();
  const email = document.getElementById("reg-email").value.trim();
  const password = document.getElementById("reg-password").value.trim();
  const confirmPassword = document.getElementById("reg-confirm-password").value.trim();

  // Validation
  if (!username || !email || !password || !confirmPassword) {
    showAlert("All fields are required", true);
    return;
  }

  // Email validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    showAlert("Please enter a valid email", true);
    return;
  }

  // Password length check
  if (password.length < 5) {
    showAlert("Password must be at least 5 characters", true);
    return;
  }

  // Password match check
  if (password !== confirmPassword) {
    showAlert("Passwords do not match", true);
    return;
  }

  // Load existing users from localStorage
  let users = JSON.parse(localStorage.getItem("registeredUsers")) || [];

  // Check if username already exists
  const userExists = users.some(u => u.username === username);
  if (userExists) {
    showAlert("Username already exists", true);
    return;
  }

  // Check if email already exists
  const emailExists = users.some(u => u.email === email);
  if (emailExists) {
    swal
    showAlert("Email already registered", true);
    return;
  }

  // Add new user
  const newUser = {
    username: username,
    email: email,
    password: password
  };

  users.push(newUser);
  localStorage.setItem("registeredUsers", JSON.stringify(users));

  showAlert("Registration Successful! Redirecting to login...");
  setTimeout(() => {
    goToLogin();
  }, 2000);
});

// Alert function
// function showAlert(message, error = false) {
//   let alertBox = document.createElement("div");
//   alertBox.className = "alert";
//   alertBox.style.background = error ? "#d9534f" : "#10563cff";
//   alertBox.textContent = message;
//   document.body.appendChild(alertBox);
//   alertBox.style.display = "block";
//   setTimeout(() => alertBox.remove(), 2500);
// }

// Alert function using SweetAlert2
function showAlert(message, error = false) {
  Swal.fire({
    title: error ? 'Error!' : 'Success!',
    text: message,
    icon: error ? 'error' : 'success',
    confirmButtonColor: error ? '#d9534f' : '#00a86b',
    confirmButtonText: 'OK',
    timer: error ? undefined : 2000,
    timerProgressBar: true
  });
}