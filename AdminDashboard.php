<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard</title><link rel="stylesheet" href="AdminDashboard.css"></head>
<body>
  <div class="dashboard-container">
    <header>
      <h1>UDUS Admission Admin Dashboard</h1>
      <button id="logoutBtn">Logout</button>
    </header>

    <section class="student-section">
      <h2>All Submitted Student Admissions</h2>
      <table id="studentTable">
        <thead>
          <tr>
            <th>#</th><th>Full Name</th><th>Personal Info</th><th>Education & O’Level</th><th>Documents</th><th>Passport</th><th>Signature</th><th>Course</th><th>Admission No.</th><th>Department</th><th>Status</th><th>Action</th>
          </tr>
        </thead>
        <tbody id="studentTableBody"></tbody>
      </table>
    </section>
  </div>

<script>
async function loadStudents(){
  const res = await fetch('admin_fetch.php');
  const j = await res.json();
  const body = document.getElementById('studentTableBody');
  body.innerHTML = '';
  if (j.status !== 'success') return;
  j.students.forEach((s, idx) => {
    body.insertAdjacentHTML('beforeend', `
      <tr>
        <td>${idx+1}</td>
        <td>${s.full_name}</td>
        <td>${s.email || ''}<br>${s.phone || ''}</td>
        <td>${s.olevel_type  || ''}</td>
        <td><button onclick="viewDocs(${s.id})">View</button></td>
        <td>${s.passport_path ? '<img src="'+s.passport_path+'" width="60">' : ''}</td>
        <td>${s.signature_path ? '<img src="'+s.signature_path+'" width="60">' : ''}</td>
        <td>${s.course || ''}</td>
        <td>${s.admission_number || ''}</td>
        <td>${s.department || ''}</td>
        <td>${s.status}</td>
        <td>
          <button onclick="openUpdate(${s.id})">Update</button>
        </td>
      </tr>
    `);
  });
}

function openUpdate(id){
  const status = prompt('Enter status (approved/rejected/pending/submitted):');
  if (!status) return;
  const adm = prompt('Admission number (leave blank to keep):','');
  const dept = prompt('Department (leave blank to keep):','');
  fetch('admin_update_status.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body: `id=${encodeURIComponent(id)}&status=${encodeURIComponent(status)}&admission_number=${encodeURIComponent(adm)}&department=${encodeURIComponent(dept)}`
  }).then(()=>loadStudents());
}

function viewDocs(id) {
    fetch(`get_documents.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                const docs = data.documents;
                let html = '<h3>Student Documents</h3><ul>';
                for(const [key, path] of Object.entries(docs)){
                    if(path){
                        html += `<li>${key}: <a href="${path}" target="_blank">View</a></li>`;
                    }
                }
                html += '</ul>';

                
                const modal = document.getElementById('docModal');
                if(modal){
                    modal.innerHTML = html;
                    modal.style.display = 'block';
                } else {
                    alert('Documents:\n' + Object.entries(docs).map(d => d[0] + ': ' + d[1]).join('\n'));
                }
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => alert('Fetch error: ' + err));
}


document.addEventListener('DOMContentLoaded', loadStudents);
</script>
</body>
</html>
