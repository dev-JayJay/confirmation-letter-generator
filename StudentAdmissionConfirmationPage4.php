<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Upload Passport & Signature</title><link rel="stylesheet" href="StudentAdmissionConfirmationPage4.css"></head>
<body>
  <div class="container">
    <h2>Upload Passport & Signature</h2>
    <form id="uploadForm" method="post" enctype="multipart/form-data" action="process_page4.php">
      <input type="hidden" id="jambNumber" name="jambNumber" value="">
      <div class="upload-section">
        <label for="passport">Upload Passport Photograph:</label>
        <input type="file" id="passport" name="passport" accept="image/*" required>
        <div class="preview"><img id="passportPreview" src="" alt="Passport Preview"></div>
      </div>

      <div class="upload-section">
        <label for="signature">Upload Signature:</label>
        <input type="file" id="signature" name="signature" accept="image/*" required>
        <div class="preview"><img id="signaturePreview" src="" alt="Signature Preview"></div>
      </div>

      <div class="btn-container">
        <button type="button" id="backBtn">⬅ Back</button>
        <button type="submit" id="saveContinueBtn">Save & Continue</button>
      </div>
    </form>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('jambNumber').value = localStorage.getItem('jambNumber') || '';
});
</script>
</body>
</html>
