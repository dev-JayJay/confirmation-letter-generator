<?php
require_once 'config.php';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Education & Documents</title>
<link rel="stylesheet" href="StudentAdmissionConfirmationPage3.css">
</head>
<body>
  <div class="page-wrap">
    <div class="container">
      <h2>Education / O'level & Document Upload</h2>
      <form id="educationForm" method="post" enctype="multipart/form-data" action="process_page2.php">
        <input type="hidden" id="jambNumber" name="jambNumber" value="">
        <fieldset class="section">
          <legend>Schools Attended</legend>
          <div class="row">
            <div class="col">
              <label for="primarySchool">Primary School</label>
              <input type="text" id="primarySchool" name="primarySchool" required>
            </div>
            <div class="col small">
              <label for="primaryYear">Year Finished</label>
              <input type="number" id="primaryYear" name="primaryYear" min="1900" max="2099" step="1" placeholder="e.g. 2008" required>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <label for="secondarySchool">Secondary School</label>
              <input type="text" id="secondarySchool" name="secondarySchool" required>
            </div>
            <div class="col small">
              <label for="secondaryYear">Year Finished</label>
              <input type="number" id="secondaryYear" name="secondaryYear" min="1900" max="2099" step="1" placeholder="e.g. 2014" required>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <label for="olevelType">O'Level Exam Used</label>
              <select id="olevelType" name="olevelType" required>
                <option value="">Select O'Level</option><option>WAEC</option><option>NECO</option><option>NABTEB</option><option>GCE</option><option>NBAIS</option>
              </select>
            </div>
          </div>

          <p class="hint">Enter up to 9 subjects and their grades. The first <strong>8</strong> subject-grade pairs are required.</p>

          <div class="subjects-grid">
<?php for($i=1;$i<=9;$i++): ?>
            <div class="subrow">
              <input type="text" id="subject<?= $i ?>" name="subject<?= $i ?>" class="subject" placeholder="Subject <?= $i ?>" <?= $i<=8 ? 'required' : '' ?>>
              <input type="text" id="grade<?= $i ?>" name="grade<?= $i ?>" class="grade" placeholder="Grade <?= $i ?>" <?= $i<=8 ? 'required' : '' ?>>
            </div>
<?php endfor; ?>
          </div>
        </fieldset>

        <fieldset class="section">
          <legend>Upload Required Documents (images or PDF)</legend>
          <div class="file-row">
            <label for="birthCert">Birth Certificate *</label>
            <input type="file" id="birthCert" name="birthCert" accept="image/*,application/pdf" required>
          </div>

          <div class="file-row">
            <label for="primaryCert">Primary School Certificate *</label>
            <input type="file" id="primaryCert" name="primaryCert" accept="image/*,application/pdf" required>
          </div>

          <div class="file-row">
            <label for="olevelOriginal">Original O'Level Result (Original) *</label>
            <input type="file" id="olevelOriginal" name="olevelOriginal" accept="image/*,application/pdf" required>
          </div>

          <div class="file-row">
            <label for="jambLetter">JAMB Admission Letter *</label>
            <input type="file" id="jambLetter" name="jambLetter" accept="image/*,application/pdf" required>
          </div>

          <div class="file-row">
            <label for="jambResult">JAMB Original Result *</label>
            <input type="file" id="jambResult" name="jambResult" accept="image/*,application/pdf" required>
          </div>

          <div class="file-row">
            <label for="indigeneCert">Indigene Certificate *</label>
            <input type="file" id="indigeneCert" name="indigeneCert" accept="image/*,application/pdf" required>
          </div>

          <p class="hint">Accepted types: JPG, PNG, PDF. Max recommended size: 5MB each.</p>
        </fieldset>

        <div class="form-actions">
          <button type="button" id="backBtn">Back</button>
          <button type="submit" id="saveContinueBtn">Save & Continue</button>
        </div>

        <div id="formMessage" class="form-message" aria-live="polite"></div>
      </form>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('jambNumber').value = localStorage.getItem('jambNumber') || '';
});
</script>
</body>
</html>
