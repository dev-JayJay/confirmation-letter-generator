<?php
require_once 'config.php';
require_once 'helpers.php';
$jamb = $_GET['jamb'] ?? '';
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Confirmation Letter</title><link rel="stylesheet" href="StudentAdmissionConfirmationPage6.css"></head>
<body>
  <div class="letter-container" id="confirmationLetter">
    <div class="header">
      <h2>USMANU DANFODIYO UNIVERSITY</h2>
      <h4>(OFFICE OF THE REGISTRAR)</h4>
      <p>P.M.B. 2346, SOKOTO, NIGERIA</p>
    </div>

    <?php
    $student = null;
    if ($jamb) {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE jamb_number = :j");
        $stmt->execute([':j'=>$jamb]);
        $student = $stmt->fetch();
    }
    ?>
    <div class="passport">
      <?php if ($student && $student['passport_path']): ?>
        <img id="passportImage" src="<?= htmlspecialchars($student['passport_path']) ?>" alt="Passport">
      <?php else: ?>
        <img id="passportImage" alt="Passport">
      <?php endif; ?>
    </div>

    <div class="letter-body">
      <p><strong>Date:</strong> <span id="issueDate"><?= date('F j, Y') ?></span></p>
      <p><strong>Name of Candidate:</strong> <span id="studentName"><?= $student ? htmlspecialchars($student['surname'].' '.$student['firstname'].' '.$student['othername']) : '' ?></span></p>
      <p><strong>Admission Number:</strong> <span id="admissionNumber"><?= $student ? htmlspecialchars($student['admission_number'] ?? '') : '' ?></span></p>

      <h3>2025/2026 SESSION CONFIRMATION OF ADMISSION</h3>
      <p>
        This is to confirm that the above-named candidate has been offered provisional admission into <strong>Usmanu Danfodiyo University, Sokoto</strong> for the 2025/2026 Academic Session.
      </p>

      <p>
        The candidate has been admitted to read <strong id="courseName"><?= $student ? htmlspecialchars($student['course'] ?? '') : '' ?></strong> 100 level in the Faculty/College/School of Science.
      </p>

      <h4>UNDERTAKING</h4>
      <p>
        I, <span id="studentFullName"><?= $student ? htmlspecialchars($student['surname'].' '.$student['firstname'].' '.$student['othername']) : '' ?></span>, the undersigned, hereby accept the provisional admission offered to me...
      </p>

      <p><strong>Dated:</strong> <span id="undertakeDate"><?= date('F j, Y') ?></span></p>

      <div class="signatures">
        <div>
           <!-- registrar signature placeholder -->
          <img id="registrarSignature" alt="Registrar Signature">
          <p>Registrar</p>
        </div>
        <div>
          <?php if ($student && $student['signature_path']): ?>
            <img id="signatureImage" src="<?= htmlspecialchars($student['signature_path']) ?>" alt="Signature">
          <?php else: ?>
            <img id="signatureImage" alt="Signature">
          <?php endif; ?>
          <p>Signature of Student</p>
        </div>
      </div>
    </div>

    <div class="print-btn">
      <button id="printBtn" onclick="window.print()">🖨️ Print Confirmation Letter</button>
    </div>
  </div>
</body>
</html>
