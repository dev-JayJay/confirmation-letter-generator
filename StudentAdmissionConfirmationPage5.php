<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Review & Confirm</title><link rel="stylesheet" href="StudentAdmissionConfirmationPage5.css"></head>
<body>
  <div class="container">
    <h2>Student Confirmation Page</h2>
    <div class="images">
      <div class="img-box"><img id="passportImage" alt="Passport"><p>Passport</p></div>
      <div class="img-box"><img id="signatureImage" alt="Signature"><p>Signature</p></div>
    </div>

    <hr />
    <h3>Personal Details</h3>
    <div id="personalDetails" class="info-section"></div>

    <h3>Educational Details</h3>
    <div id="educationDetails" class="info-section"></div>

    <div class="btn-container">
      <button id="backBtn">⬅ Back</button>
      <button id="confirmBtn">✅ Confirm & Submit</button>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const jamb = localStorage.getItem('jambNumber');
  if (!jamb) { alert('Missing JAMB number'); window.location.href='index.html'; return; }
  fetch('get_student.php?jamb=' + encodeURIComponent(jamb))
    .then(r => r.json())
    .then(resp => {
      if (resp.status !== 'success') return alert(resp.message || 'Failed to load');
      const s = resp.student;
      // display personal
      document.getElementById('personalDetails').innerHTML = `
        <p><strong>Name:</strong> ${s.surname || ''} ${s.firstname || ''} ${s.othername || ''}</p>
        <p><strong>Email:</strong> ${s.email || ''}</p>
        <p><strong>Phone:</strong> ${s.phone || ''}</p>
      `;
      // passport and signature
      if (s.passport_path) document.getElementById('passportImage').src = s.passport_path;
      if (s.signature_path) document.getElementById('signatureImage').src = s.signature_path;
      // education:
      if (resp.education) {
        const ed = resp.education;
        let subhtml = '<ul>';
        resp.subjects.forEach(sb => subhtml += `<li>${sb.subject_name} - ${sb.grade}</li>`);
        subhtml += '</ul>';
        document.getElementById('educationDetails').innerHTML = `
          <p><strong>Primary:</strong> ${ed.primary_school || ''} (${ed.primary_year || ''})</p>
          <p><strong>Secondary:</strong> ${ed.secondary_school || ''} (${ed.secondary_year || ''})</p>
          <p><strong>O'Level:</strong> ${ed.olevel_type || ''}</p>
          <p><strong>Subjects:</strong> ${subhtml}</p>
        `;
      }
    });

  document.getElementById('confirmBtn').addEventListener('click', () => {
    const jamb = localStorage.getItem('jambNumber');
    fetch('finalize_submission.php', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: 'jambNumber=' + encodeURIComponent(jamb)
    }).then(r=>r.json()).then(j=>{
      if (j.status === 'success') window.location.href = 'StudentAdmissionConfirmationPage6.php?jamb=' + encodeURIComponent(localStorage.getItem('jambNumber'));
      else alert(j.message || 'Failed to submit');
    });
  });
});
</script>
</body>
</html>
