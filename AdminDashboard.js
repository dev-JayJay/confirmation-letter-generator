document.addEventListener("DOMContentLoaded", () => {
  const students = [
    {
      id: 1,
      name: "Aisha Bello",
      personal: "Female, Age: 19, State: Sokoto",
      education: "WAEC: 9 Credits (Science Subjects), Primary School: FGC Sokoto, Year Finished: 2014",
      documents: {
        birthCert: "https://i.imgur.com/XIFgH5x.png",
        primaryCert: "https://i.imgur.com/J5X98vF.png",
        olevelOriginal: "https://i.imgur.com/FW0sHqF.png",
        jambLetter: "https://i.imgur.com/TMmt0Xt.png",
        jambResult: "https://i.imgur.com/6H3gXnF.png",
        indigeneCert: "https://i.imgur.com/az1CzGk.png"
      },
      passport: "https://i.imgur.com/Yf6P7Cj.png",
      signature: "https://i.imgur.com/p3Q5m7n.png",
      course: "Computer Science",
      admissionNo: "UDUS/2025/CS/10234",
      department: "Science",
      status: "Pending"
    },
    {
      id: 2,
      name: "Abdulrahman Musa",
      personal: "Male, Age: 21, State: Kebbi",
      education: "NECO: 8 Credits (Science Subjects), Primary School: Unity College, Year Finished: 2015",
      documents: {
        birthCert: "https://i.imgur.com/WJHMQ3r.png",
        primaryCert: "https://i.imgur.com/M2NVwHk.png",
        olevelOriginal: "https://i.imgur.com/RK9cN83.png",
        jambLetter: "https://i.imgur.com/Ytxb9pH.png",
        jambResult: "https://i.imgur.com/svK8Utx.png",
        indigeneCert: "https://i.imgur.com/az1CzGk.png"
      },
      passport: "https://i.imgur.com/eM3zHHO.png",
      signature: "https://i.imgur.com/9XQnGo1.png",
      course: "Biochemistry",
      admissionNo: "UDUS/2025/BC/11245",
      department: "Science",
      status: "Pending"
    }
  ];

  const tableBody = document.getElementById("studentTableBody");

  students.forEach((student) => {
    const docs = student.documents;
    const docLinks = `
      <a href="${docs.birthCert}" target="_blank">Birth Cert</a><br>
      <a href="${docs.primaryCert}" target="_blank">Primary Cert</a><br>
      <a href="${docs.olevelOriginal}" target="_blank">O’Level</a><br>
      <a href="${docs.jambLetter}" target="_blank">JAMB Letter</a><br>
      <a href="${docs.jambResult}" target="_blank">JAMB Result</a><br>
      <a href="${docs.indigeneCert}" target="_blank">Indigene Cert</a>
    `;

    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${student.id}</td>
      <td>${student.name}</td>
      <td>${student.personal}</td>
      <td>${student.education}</td>
      <td>${docLinks}</td>
      <td><img src="${student.passport}" alt="Passport"></td>
      <td><img src="${student.signature}" alt="Signature"></td>
      <td>${student.course}</td>
      <td>${student.admissionNo}</td>
      <td>${student.department}</td>
      <td class="status">${student.status}</td>
      <td>
        <button class="action approve">Approve</button>
        <button class="action reject">Reject</button>
      </td>
    `;
    tableBody.appendChild(row);
  });

  // Approve/Reject
  tableBody.addEventListener("click", (e) => {
    if (e.target.classList.contains("approve")) {
      const row = e.target.closest("tr");
      const statusCell = row.querySelector(".status");
      statusCell.textContent = "Approved";
      statusCell.className = "status approved";
    }

    if (e.target.classList.contains("reject")) {
      const row = e.target.closest("tr");
      const statusCell = row.querySelector(".status");
      statusCell.textContent = "Rejected";
      statusCell.className = "status rejected";
    }
  });

  // Logout
  document.getElementById("logoutBtn").addEventListener("click", () => {
    alert("Logged out successfully!");
    window.location.href = "index.html";
  });
});
