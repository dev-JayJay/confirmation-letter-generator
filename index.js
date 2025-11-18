// ====================== 🎓 STUDENT ADMISSION CHECK ======================
document.getElementById("loginForm").addEventListener("submit", function(event) {
  event.preventDefault();

  const jambInput = document.getElementById("jambNumber");
  const jambNumber = jambInput.value.trim();
  const messageBox = document.getElementById("messageBox");

  jambInput.classList.remove("input-error");
  messageBox.style.display = "block";

  if (jambNumber === "") {
    jambInput.classList.add("input-error");
    messageBox.textContent = "⚠️ Please enter your JAMB Admission Number.";
    messageBox.className = "message error";
    return;
  }

  const admittedStudents = ["2023123456AB", "2023987654CD", "2023555123EF"];

  if (admittedStudents.includes(jambNumber)) {
    localStorage.setItem("jambNumber", jambNumber);
    messageBox.innerHTML = `
      <h4>🎉 Congratulations!</h4>
      <p>You have been given admission.</p>
      <a href="StudentAdmissionConfirmationPage2.php" id="continueBtn">Continue to generate your confirmation letter</a>
    `;
    messageBox.className = "message success";
  } else {
    messageBox.textContent = "❌ Sorry, you have not been given admission yet.";
    messageBox.className = "message error";
  }
});


// ====================== 🔐 ADMIN LOGIN FUNCTIONALITY ======================
document.addEventListener("DOMContentLoaded", function () {
  const adminLink = document.getElementById("adminLoginLink");
  const adminPopup = document.getElementById("adminLoginPopup");
  const closePopup = document.getElementById("closePopup");
  const adminForm = document.getElementById("adminForm");
  const adminMessage = document.getElementById("adminMessage");

  // Safety check
  if (!adminLink || !adminPopup || !closePopup || !adminForm || !adminMessage) {
    console.warn("⚠️ Admin login elements not found on this page.");
    return;
  }

  // Open popup
  adminLink.addEventListener("click", (e) => {
    e.preventDefault();
    adminPopup.style.display = "flex";
  });

  // Close popup
  closePopup.addEventListener("click", () => {
    adminPopup.style.display = "none";
    adminMessage.textContent = "";
  });

  // Handle login
  adminForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const username = document.getElementById("adminUsername").value.trim();
    const password = document.getElementById("adminPassword").value.trim();

    const adminUser = "admin";
    const adminPass = "12345";

    if (username === adminUser && password === adminPass) {
      adminMessage.textContent = "✅ Login successful! Redirecting...";
      adminMessage.className = "message success";
      adminMessage.style.display = "block";

      localStorage.setItem("adminLoggedIn", "true");

      setTimeout(() => {
        window.location.href = "AdminDashboard.php";
      }, 1500);
    } else {
      adminMessage.textContent = "❌ Invalid username or password.";
      adminMessage.className = "message error";
      adminMessage.style.display = "block";
    }
  });
});
