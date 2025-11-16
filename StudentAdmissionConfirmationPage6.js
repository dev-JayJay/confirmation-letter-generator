document.addEventListener("DOMContentLoaded", function () {
  // Load stored info
  const surname = localStorage.getItem("surname") || "N/A";
  const firstname = localStorage.getItem("firstname") || "";
  const othername = localStorage.getItem("othername") || "";
  const passport = localStorage.getItem("passport") || "";
  const signature = localStorage.getItem("signature") || "";

  // Generate admission number and course
  const admissionNumber = "UDUS/" + new Date().getFullYear() + "/CS/" + Math.floor(Math.random() * 90000 + 10000);
  const courses = ["Computer Science", "Biochemistry", "Physics", "Microbiology", "Mathematics", "Statistics", "Geology"];
  const randomCourse = courses[Math.floor(Math.random() * courses.length)];

  // Insert data
  document.getElementById("studentName").textContent = `${surname.toUpperCase()} ${firstname} ${othername}`;
  document.getElementById("studentFullName").textContent = `${surname.toUpperCase()} ${firstname} ${othername}`;
  document.getElementById("admissionNumber").textContent = admissionNumber;
  document.getElementById("courseName").textContent = randomCourse;

  // Dates
  const today = new Date().toLocaleDateString();
  document.getElementById("issueDate").textContent = today;
  document.getElementById("undertakeDate").textContent = today;

  // Passport & Signature
  if (passport) document.getElementById("passportImage").src = passport;
  if (signature) document.getElementById("signatureImage").src = signature;
  // Registrar signature (auto display)
  document.getElementById("registrarSignature").src = "regissign.png";


  // Print button
  document.getElementById("printBtn").addEventListener("click", function () {
    window.print();
  });
});
