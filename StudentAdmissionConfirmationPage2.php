<?php
// StudentAdmissionConfirmationPage2.php
require_once 'config.php';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Student Confirmation - Personal Details</title>
<link rel="stylesheet" href="StudentAdmissionConfirmationPage2.css">
</head>
<body>
  <div class="container">
    <h2>Personal Details</h2>
    <form id="confirmationForm" method="post" action="process_page1.php">
      <input type="hidden" id="jambNumber" name="jambNumber" value="">
      <div class="form-group">
        <label for="jambNumberDisplay">JAMB Admission Number:</label>
        <input type="text" id="jambNumberDisplay" readonly>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="surname">Surname:</label>
          <input type="text" id="surname" name="surname" placeholder="Enter your Surname" required>
        </div>

        <input type="hidden" name="admission_number" id="admission_number">
        <input type="hidden" name="course" id="course">
        <input type="hidden" name="department" id="department">

        <div class="form-group">
          <label for="firstname">First Name:</label>
          <input type="text" id="firstname" name="firstname" placeholder="Enter your Firstname" required>
        </div>
        <div class="form-group">
          <label for="othername">Other Name:</label>
          <input type="text" id="othername" name="othername" placeholder="Enter your othername">
        </div>
      </div>

      <!-- date/gender/religion -->
      <div class="form-row">
        <div class="form-group">
          <label for="dob">Date of Birth:</label>
          <input type="date" id="dob" name="dob" required>
        </div>
        <div class="form-group">
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" required>
            <option value="">Select Gender</option><option value="Male">Male</option><option value="Female">Female</option>
          </select>
        </div>
        <div class="form-group">
          <label for="religion">Religion:</label>
          <select id="religion" name="religion" required>
            <option value="">Select Religion</option><option value="Islam">Islam</option><option value="Christianity">Christianity</option><option value="Others">Others</option>
          </select>
        </div>
      </div>

      <!-- email, maritalStatus, phone -->
      <div class="form-row">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Enter your Email" required>
        </div>
        <div class="form-group">
          <label for="maritalStatus">Marital Status:</label>
          <select id="maritalStatus" name="maritalStatus" required>
            <option value="">Select Status</option><option value="Single">Single</option><option value="Married">Married</option><option value="Divorced">Divorced</option>
          </select>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number:</label>
          <input type="text" id="phone" name="phone" placeholder="Enter your Sponsor's Phone Number" required>
        </div>
      </div>

      <!-- state,lga,nin -->
      <div class="form-row">
        <div class="form-group">
          <label for="state">State of Origin:</label>
          <input id="state" name="state" required type="text"  placeholder="Enter your State of Origin" />
        </div>
        <div class="form-group">
          <label for="lga">Local Government Area:</label>
          <input type="text" id="lga" name="lga" placeholder="Enter your LGA" required>
        </div>
        <div class="form-group">
          <label for="nin">National Identification Number (NIN):</label>
          <input type="text" id="nin" name="nin" placeholder="Enter your NIN" required>
        </div>
      </div>

      <div class="form-group">
        <label for="residentialAddress">Residential Address:</label>
        <input type="text" id="residentialAddress" name="residentialAddress" placeholder="Enter your Residential Address" required>
      </div>
      <div class="form-group">
        <label for="homeAddress">Permanent Home Address:</label>
        <input type="text" id="homeAddress" name="homeAddress" placeholder="Enter your Permanent Home Address" required>
      </div>

      <h3>Sponsor's Information</h3>
      <div class="form-row">
        <div class="form-group">
          <label for="sponsorName">Sponsor's Name:</label>
          <input type="text" id="sponsorName" name="sponsorName" placeholder="Enter your Sponsor's Name" required>
        </div>
        <div class="form-group">
          <label for="sponsorEmail">Sponsor's Email:</label>
          <input type="email" id="sponsorEmail" name="sponsorEmail" placeholder="Enter your Sponsor's Email" required>
        </div>
        <div class="form-group">
          <label for="sponsorPhone">Sponsor's Phone Number:</label>
          <input type="text" id="sponsorPhone" name="sponsorPhone" placeholder="Enter your Sponsor's Phone Number" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="sponsorState">Sponsor's State:</label>
          <!-- <select id="sponsorState" name="sponsorState" required></select> -->
          <input id="sponsorState" name="sponsorState" required type="text"  placeholder="Enter your Sponsor State of Origin" />
        </div>
        <div class="form-group">
          <label for="sponsorLga">Sponsor's Local Government Area:</label>
          <input type="text" id="sponsorLga" name="sponsorLga" placeholder="Enter your Sponsor's LGA" required>
        </div>
      </div>

      <div class="form-group">
        <label for="sponsorAddress">Sponsor's Home Address:</label>
        <input type="text" id="sponsorAddress" name="sponsorAddress" placeholder="Enter your Sponsor's Home Address" required>
      </div>

      <h3>Next of Kin’s Information</h3>
      <div class="form-row">
        <div class="form-group">
          <label for="kinName">Next of Kin's Name:</label>
          <input type="text" id="kinName" name="kinName" placeholder="Enter your Next of Kin's Name" required>
        </div>
        <div class="form-group">
          <label for="kinEmail">Next of Kin's Email:</label>
          <input type="email" id="kinEmail" name="kinEmail" placeholder="Enter your Next of Kin's Email" required>
        </div>
        <div class="form-group">
          <label for="kinPhone">Next of Kin's Phone Number:</label>
          <input type="text" id="kinPhone" name="kinPhone" placeholder="Enter your Next of Kin's Phone Number" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="kinState">Next of Kin's State:</label>
          <input id="kinState" name="kinState" required type="text"  placeholder="Enter your Sponsor State of Origin" />
          <!-- <select id="kinState" name="kinState" required></select> -->
          
        </div>
        <div class="form-group">
          <label for="kinLga">Next of Kin's Local Government Area:</label>
          <input type="text" id="kinLga" name="kinLga" placeholder="Enter your Next of Kin's LGA" required>
        </div>
      </div>

      <div class="form-group">
        <label for="kinAddress">Next of Kin's Home Address:</label>
        <input type="text" id="kinAddress" name="kinAddress" placeholder="Enter your Next of Kin's Home Address" required>
      </div>

      <div class="buttons">
        <button type="button" id="backBtn">Back</button>
        <button type="submit" id="saveContinueBtn">Save & Continue</button>
      </div>
    </form>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  // Load JAMB number
  const storedJamb = localStorage.getItem('jambNumber') || '';
  document.getElementById('jambNumber').value = storedJamb;
  document.getElementById('jambNumberDisplay').value = storedJamb;

  // Admission number
  const admissionNumber =
    "UDUS/" + new Date().getFullYear() + "/CS/" +
    Math.floor(Math.random() * 90000 + 10000);

  // Random course & department
  const courses = [
    "Computer Science", "Biochemistry", "Physics",
    "Microbiology", "Mathematics", "Statistics", "Geology"
  ];

  const departments = [
    "Faculty of Science", "Faculty of Arts", "Faculty of Education"
  ];

  document.getElementById("admission_number").value = admissionNumber;
  document.getElementById("course").value =
    courses[Math.floor(Math.random() * courses.length)];
  document.getElementById("department").value =
    departments[Math.floor(Math.random() * departments.length)];

  // Back button
  document.getElementById("backBtn").addEventListener("click", () => {
    window.location.href = "StudentAdmissionConfirmation.html";
  });

});
</script>

</body>
</html>
