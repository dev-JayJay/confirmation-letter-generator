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
<div id="docModal" style="
  display:none;
  position:fixed;
  top:0; left:0; width:100%; height:100%;
  background:rgba(0,0,0,0.8); color:white; overflow:auto; padding:20px; z-index:9999;
">
  <div style="
    background:#222; 
    padding:20px; 
    border-radius:8px; 
    max-width:90%; 
    margin:40px auto; 
    color:white;
  ">
    <button onclick="closeModal()" 
            style="float:right; background:red; color:white; padding:5px 10px; border:none; cursor:pointer;">
      Close
    </button>
    <h2>Student Documents</h2>
    <div id="docContent" style="display:flex; flex-wrap:wrap;"></div>
  </div>
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

function closeModal() {
    const modal = document.getElementById('docModal');
    modal.style.display = 'none';
    document.getElementById('docContent').innerHTML = '';
}

function viewDocs(studentId) {
    fetch(`get_documents.php?id=${studentId}`)
        .then(res => res.json())
        .then(data => {
            if(data.status !== 'success') {
                alert('Error: ' + data.message);
                return;
            }

            const docs = data.documents;
            const docContent = document.getElementById('docContent');
            docContent.innerHTML = ''; // clear previous

            for(const [docType, path] of Object.entries(docs)) {
                if(!path) continue;

                const ext = path.split('.').pop().toLowerCase();
                const container = document.createElement('div');
                container.style.margin = '10px';
                container.style.textAlign = 'center';
                container.style.flex = '0 0 200px';

                const title = document.createElement('strong');
                title.textContent = docType.replace(/_/g, ' ');
                container.appendChild(title);

                container.appendChild(document.createElement('br'));

                if(['jpg','jpeg','png','gif'].includes(ext)) {
                    const img = document.createElement('img');
                    img.src = path;
                    img.style.maxWidth = '180px';
                    img.style.maxHeight = '180px';
                    img.style.border = '1px solid #555';
                    img.style.borderRadius = '4px';
                    img.style.marginTop = '5px';
                    container.appendChild(img);
                } else {
                    const link = document.createElement('a');
                    link.href = path;
                    link.target = '_blank';
                    link.style.color = '#0af';
                    link.textContent = 'View Document';
                    container.appendChild(link);
                }

                docContent.appendChild(container);
            }

            document.getElementById('docModal').style.display = 'block';
        })
        .catch(err => {
            alert('Fetch error: ' + err);
        });
}

document.addEventListener('DOMContentLoaded', loadStudents);
</script>
</body>
</html>
