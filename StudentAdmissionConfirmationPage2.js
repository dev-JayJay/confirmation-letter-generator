document.addEventListener("DOMContentLoaded", function () {
  const jambInput = document.getElementById("jambNumber");
  const states = [
    "Abia",
    "Adamawa",
    "Akwa Ibom",
    "Anambra",
    "Bauchi",
    "Bayelsa",
    "Benue",
    "Borno",
    "Cross River",
    "Delta",
    "Ebonyi",
    "Edo",
    "Ekiti",
    "Enugu",
    "Gombe",
    "Imo",
    "Jigawa",
    "Kaduna",
    "Kano",
    "Katsina",
    "Kebbi",
    "Kogi",
    "Kwara",
    "Lagos",
    "Nasarawa",
    "Niger",
    "Ogun",
    "Ondo",
    "Osun",
    "Oyo",
    "Plateau",
    "Rivers",
    "Sokoto",
    "Taraba",
    "Yobe",
    "Zamfara",
    "FCT",
  ];

  // Populate state dropdowns
  ["state", "sponsorState", "kinState"].forEach((id) => {
    const select = document.getElementById(id);
    states.forEach((state) => {
      const option = document.createElement("option");
      option.value = state;
      option.textContent = state;
      select.appendChild(option);
    });
  });

  // Load JAMB number from previous page
  const storedJamb = localStorage.getItem("jambNumber");
  if (storedJamb) jambInput.value = storedJamb;

  const admissionNumber =
    "UDUS/" +
    new Date().getFullYear() +
    "/CS/" +
    Math.floor(Math.random() * 90000 + 10000);

  const courses = [
    "Computer Science",
    "Biochemistry",
    "Physics",
    "Microbiology",
    "Mathematics",
    "Statistics",
    "Geology",
  ];
  const departments = [
    "Faculty of Science",
    "Faculty of Arts",
    "Faculty of Education",
  ];

  const randomCourse = courses[Math.floor(Math.random() * courses.length)];
  const randomDept =
    departments[Math.floor(Math.random() * departments.length)];

  // 🔥 Set hidden values immediately
  document.getElementById("admission_number").value = admissionNumber;
  document.getElementById("course").value = randomCourse;
  document.getElementById("department").value = randomDept;

  // Back button
  document.getElementById("backBtn").addEventListener("click", () => {
    window.location.href = "StudentAdmissionConfirmation.html";
  });

  // Save & Continue
  document
    .getElementById("confirmationForm")
    .addEventListener("submit", (e) => {
      // e.preventDefault();

      // Collect all form data
      const formData = {
        jambNumber: document.getElementById("jambNumber").value,
        nin: document.getElementById("nin").value,
        surname: document.getElementById("surname").value,
        firstname: document.getElementById("firstname").value,
        othername: document.getElementById("othername").value,
        dob: document.getElementById("dob").value,
        gender: document.getElementById("gender").value,
        religion: document.getElementById("religion").value,
        email: document.getElementById("email").value,
        maritalStatus: document.getElementById("maritalStatus").value,
        phone: document.getElementById("phone").value,
        state: document.getElementById("state").value,
        lga: document.getElementById("lga").value,
        residentialAddress: document.getElementById("residentialAddress").value,
        homeAddress: document.getElementById("homeAddress").value,

        sponsorName: document.getElementById("sponsorName").value,
        sponsorEmail: document.getElementById("sponsorEmail").value,
        sponsorPhone: document.getElementById("sponsorPhone").value,
        sponsorState: document.getElementById("sponsorState").value,
        sponsorLga: document.getElementById("sponsorLga").value,
        sponsorAddress: document.getElementById("sponsorAddress").value,

        kinName: document.getElementById("kinName").value,
        kinEmail: document.getElementById("kinEmail").value,
        kinPhone: document.getElementById("kinPhone").value,
        kinState: document.getElementById("kinState").value,
        kinLga: document.getElementById("kinLga").value,
        kinAddress: document.getElementById("kinAddress").value,

        admission_number: document.getElementById("admission_number").value,
        course: document.getElementById("course").value,
        department: document.getElementById("department").value,
      };

      // Save to localStorage
      for (let key in formData) {
        localStorage.setItem(key, formData[key]);
      }

      alert(
        "✅ Personal details saved successfully! Proceeding to next page..."
      );
      return true;
    });
});
