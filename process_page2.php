<?php
require_once 'config.php';
require_once 'helpers.php';
header('Content-Type: application/json');

$ALLOWED_EXT = ['jpg','jpeg','png','pdf'];
$MAX_BYTES = 5 * 1024 * 1024;

try {
    $jamb = safe($_POST['jambNumber'] ?? '');
    if (!$jamb) throw new Exception('Missing jambNumber');

    $stmt = $pdo->prepare("SELECT id FROM students WHERE jamb_number = :j");
    $stmt->execute([':j'=>$jamb]);
    $student = $stmt->fetch();
    if (!$student) throw new Exception('Student not found. Complete personal details first.');

    $studentId = (int)$student['id'];
    $primarySchool = safe($_POST['primarySchool'] ?? '');
    $primaryYear = safe($_POST['primaryYear'] ?? null);
    $secondarySchool = safe($_POST['secondarySchool'] ?? '');
    $secondaryYear = safe($_POST['secondaryYear'] ?? null);
    $olevelType = safe($_POST['olevelType'] ?? '');

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id FROM students_education WHERE student_id = :sid");
    $stmt->execute([':sid'=>$studentId]);
    $edu = $stmt->fetch();

    if ($edu) {
        $pdo->prepare("UPDATE students_education SET primary_school=:ps, primary_year=:py, secondary_school=:ss, secondary_year=:sy, olevel_type=:ot WHERE student_id=:sid")
            ->execute([':ps'=>$primarySchool, ':py'=>$primaryYear ?: null, ':ss'=>$secondarySchool, ':sy'=>$secondaryYear ?: null, ':ot'=>$olevelType, ':sid'=>$studentId]);
    } else {
        $pdo->prepare("INSERT INTO students_education (student_id, primary_school, primary_year, secondary_school, secondary_year, olevel_type) VALUES (:sid,:ps,:py,:ss,:sy,:ot)")
            ->execute([':sid'=>$studentId, ':ps'=>$primarySchool, ':py'=>$primaryYear ?: null, ':ss'=>$secondarySchool, ':sy'=>$secondaryYear ?: null, ':ot'=>$olevelType]);
    }

    // subjects
    $pdo->prepare("DELETE FROM olevel_subjects WHERE student_id = :sid")->execute([':sid'=>$studentId]);
    $ins = $pdo->prepare("INSERT INTO olevel_subjects (student_id, subject_order, subject_name, grade) VALUES (:sid, :ord, :sub, :gr)");
    for ($i=1;$i<=9;$i++) {
        $s = safe($_POST["subject{$i}"] ?? '');
        $g = safe($_POST["grade{$i}"] ?? '');
        if ($s !== '' || $g !== '') $ins->execute([':sid'=>$studentId, ':ord'=>$i, ':sub'=>$s, ':gr'=>$g]);
    }

    // handle document uploads
    $expectedFiles = [
      'birthCert'=>'birth_certificate',
      'primaryCert'=>'primary_certificate',
      'olevelOriginal'=>'olevel_original',
      'jambLetter'=>'jamb_letter',
      'jambResult'=>'jamb_result',
      'indigeneCert'=>'indigene_certificate'
    ];
    $uploadDir = __DIR__ . '/uploads/documents/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $insDoc = $pdo->prepare("INSERT INTO student_documents (student_id, doc_type, file_path) VALUES (:sid, :dt, :fp)");

    foreach ($expectedFiles as $inputName => $docType) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $tmp = $_FILES[$inputName]['tmp_name'];
            $orig = $_FILES[$inputName]['name'];
            if (!allowed_file($tmp, $orig, $ALLOWED_EXT, $MAX_BYTES)) throw new Exception("Invalid file for $inputName.");
            $newName = make_upload_name($docType, $orig);
            $dest = $uploadDir . $newName;
            if (!move_uploaded_file($tmp, $dest)) throw new Exception("Failed to move uploaded file for $inputName");
            $rel = 'uploads/documents/' . $newName;
            $insDoc->execute([':sid'=>$studentId, ':dt'=>$docType, ':fp'=>$rel]);
        }
    }

    // keep status as pending
    $pdo->prepare("UPDATE students SET status = 'pending' WHERE id = :id")->execute([':id'=>$studentId]);

    $pdo->commit();
    // echo json_encode(['status'=>'success','student_id'=>$studentId]);
    header("Location: StudentAdmissionConfirmationPage4.php?student_id=" . $studentId);
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
