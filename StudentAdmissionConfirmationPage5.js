document.addEventListener("DOMContentLoaded", function() {
  const personalDetailsDiv = document.getElementById("personalDetails");
  const educationDetailsDiv = document.getElementById("educationDetails");

  // Helper to safely get stored values
  const getData = key => localStorage.getItem(key) || "Not available";

  // ===== PASSPORT & SIGNATURE =====
  const passportImg = document.getElementById("passportImage");
  const signatureImg = document.getElementById("signatureImage");
  const passport = localStorage.getItem("passport");
  const signature = localStorage.getItem("signature");

  passportImg.src = passport ? passport : "placeholder.png";
  signatureImg.src = signature ? signature : "placeholder.png";

  // ===== LOAD JAMB NUMBER =====
  const jambNumber = localStorage.getItem("jambNumber") || "";

  // ===== PERSONAL DETAILS (PAGE 2) =====
  const personalInfo = `
    <p><strong>JAMB Registration Number:</strong> ${jambNumber}</p>
   <p><strong>Full Name:</strong> ${(localStorage.getItem("surname") || "") + " " + (localStorage.getItem("firstname") || "") + " " + (localStorage.getItem("othername") || "")}</p>
    <p><strong>Gender:</strong> ${getData("gender")}</p>
    <p><strong>Date of Birth:</strong> ${getData("dob")}</p>
    <p><strong>NIN:</strong> ${getData("nin")}</p>
    <p><strong>State of Origin:</strong> ${getData("state")}</p>
    <p><strong>Local Government Area:</strong> ${getData("lga")}</p>
    <p><strong>Phone Number:</strong> ${getData("phone")}</p>
    <p><strong>Email Address:</strong> ${getData("email")}</p>
    <hr>
    <h4>Next of Kin Information</h4>
    <p><strong>Name:</strong> ${getData("kinName")}</p>
    <p><strong>Email:</strong> ${getData("kinEmail")}</p>
    <p><strong>Phone:</strong> ${getData("kinPhone")}</p>
    <p><strong>State:</strong> ${getData("kinState")}</p>
    <p><strong>Address:</strong> ${getData("kinAddress")}</p>
    <hr>
    <h4>Sponsor Information</h4>
    <p><strong>Name:</strong> ${getData("sponsorName")}</p>
    <p><strong>Email:</strong> ${getData("sponsorEmail")}</p>
    <p><strong>Phone:</strong> ${getData("sponsorPhone")}</p>
    <p><strong>State:</strong> ${getData("sponsorState")}</p>
    <p><strong>Address:</strong> ${getData("sponsorAddress")}</p>
  `;
  personalDetailsDiv.innerHTML = personalInfo;

  // ===== EDUCATIONAL DETAILS (PAGE 3) =====
  const eduInfo = `
    <p><strong>Primary School Attended:</strong> ${getData("primarySchool")}</p>
    <p><strong>Year Finished:</strong> ${getData("primaryYear")}</p>
    <p><strong>Secondary School Attended:</strong> ${getData("secondarySchool")}</p>
    <p><strong>Year Finished:</strong> ${getData("secondaryYear")}</p>
    <p><strong>O'Level Exam Used:</strong> ${getData("olevelExam")}</p>
    <h4>Subjects and Grades</h4>
    <ul>
      ${Array.from({ length: 9 }, (_, i) => {
        const subj = getData(`subject${i+1}`);
        const grade = getData(`grade${i+1}`);
        return `<li>${subj}: <strong>${grade}</strong></li>`;
      }).join("")}
    </ul>
  `;
  educationDetailsDiv.innerHTML = eduInfo;

  // ===== BACK BUTTON =====
  document.getElementById("backBtn").addEventListener("click", () => {
    window.location.href = "StudentAdmissionConfirmationPage4.html";
  });

  // ===== CONFIRM & SUBMIT BUTTON =====
  document.getElementById("confirmBtn").addEventListener("click", () => {
    const warningBox = document.createElement("div");
    warningBox.className = "warning-popup";
    warningBox.innerHTML = `
      <div class="popup-content">
        <h3>⚠️ Warning!</h3>
        <p>Once you submit, you will <strong>not</strong> be able to make any corrections again.</p>
        <div class="popup-buttons">
          <button id="cancelSubmit">Cancel</button>
          <button id="finalSubmit">Continue</button>
        </div>
      </div>
    `;
    document.body.appendChild(warningBox);

    document.getElementById("cancelSubmit").addEventListener("click", () => {
      warningBox.remove();
    });

    document.getElementById("finalSubmit").addEventListener("click", () => {
      alert("✅ Your confirmation has been successfully submitted!");

      // Keep only data needed for the confirmation letter (Page 6)
      const keepData = {
        surname: localStorage.getItem("surname"),
        firstname: localStorage.getItem("firstname"),
        othername: localStorage.getItem("othername"),
        passport: localStorage.getItem("passport"),
        signature: localStorage.getItem("signature"),
        jambNumber: localStorage.getItem("jambNumber") // ✅ keep JAMB number
      };

      // Clear all other stored data
      localStorage.clear();

      // Restore the important data
      for (const [key, value] of Object.entries(keepData)) {
        if (value) localStorage.setItem(key, value);
      }

      // Redirect to confirmation letter page
      window.location.href = "StudentAdmissionConfirmationPage6.html";
    });
  });
});
