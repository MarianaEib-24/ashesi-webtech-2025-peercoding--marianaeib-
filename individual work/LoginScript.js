const loginBtn = document.getElementById("loginBtn");
const loginSection = document.getElementById("login-section");
const dashboardSection = document.getElementById("dashboard-section");


const users = [
    {"username": "mari.eib", "password":"12345"},
    {"username": "solomon.ayitey", "password":"bighead"},
    {"username": "barbie.marie", "password":"54321"},
    {"username": "kgasaafo.maafo", "password":"45678"},
    {"username": "julia.aryee", "password":"67890"}
];

function goToDashboard() {
    window.location.href = "DashboardFI.html";
}

loginBtn.addEventListener("click", () => {
  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();

  if (!username || !password) {
    showAlert("Enter username and password", true);
    return;
  }
  

  // FETCH USER DATA FROM JSON FILE
//   fetch("users.json")
//     .then(response => response.json())
//     .then(users => {
      // Check if the username and password match any record
    const user = users.find(u => u.username === username && u.password === password);

    if (user) {
        showAlert("Login successful!");
        goToDashboard();
        // setTimeout(() => {
        //   loginSection.style.display = "none";
        //   dashboardSection.style.display = "block";
        // }, 1000);
      } else {
        showAlert("Invalid username or password,try again", true);
      }
    });
//     .catch(() => showAlert("Error loading user data", true));
// });

//function for showAlert 
function showAlert(message, error = false) {
  let alertBox = document.createElement("div");
  alertBox.className = "alert";
  alertBox.style.background = error ? "#d9534f" : "#10563cff";
  alertBox.textContent = message;
  document.body.appendChild(alertBox);
  alertBox.style.display = "block";
  setTimeout(() => alertBox.remove(), 3000);
}

// Alert function using SweetAlert2
// function showAlert(message, error = false) {
//   Swal.fire({
//     title: error ? 'Error!' : 'Success!',
//     text: message,
//     icon: error ? 'error' : 'success',
//     confirmButtonColor: error ? '#d9534f' : '#00a86b',
//     confirmButtonText: 'OK',
//     timer: error ? undefined : 2000,
//     timerProgressBar: true
//   });
// }  