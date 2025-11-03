const loginBtn = document.getElementById("loginBtn");
const loginSection = document.getElementById("login-section");
const dashboardSection = document.getElementById("dashboard-section");

loginBtn.addEventListener("click", () => {
  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();

  if (!username || !password) {
    showAlert("Enter username and password", true);
    return;
  }
  

  // FETCH USER DATA FROM JSON FILE
  fetch("users.json")
    .then(response => response.json())
    .then(users => {
      // Check if the username and password match any record
      const user = users.find(u => u.username === username && u.password === password);

      if (user) {
        showAlert("Login Successful");
        setTimeout(() => {
          loginSection.style.display = "none";
          dashboardSection.style.display = "block";
        }, 1000);
      } else {
        showAlert("Invalid username or password", true);
      }
    })
    .catch(() => showAlert("Error loading user data", true));
});

function showAlert(message, error = false) {
  let alertBox = document.createElement("div");
  alertBox.className = "alert";
  alertBox.style.background = error ? "#d9534f" : "#00a86b";
  alertBox.textContent = message;
  document.body.appendChild(alertBox);
  alertBox.style.display = "block";
  setTimeout(() => alertBox.remove(), 2000);
}

// Navigation buttons
const navButtons = document.querySelectorAll(".nav-btn");
const sections = document.querySelectorAll(".content-section");

navButtons.forEach(btn => {
  btn.addEventListener("click", () => {
    sections.forEach(sec => sec.classList.remove("active"));
    const target = btn.getAttribute("data-section");
    document.getElementById(target).classList.add("active");
  });
});
