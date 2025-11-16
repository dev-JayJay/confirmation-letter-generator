<?php
require_once 'config.php';
require_once 'helpers.php';
header('Content-Type: application/json');

$ALLOWED_EXT = ['jpg','jpeg','png'];
$MAX_BYTES = 2.5 * 1024 * 1024;

try {
    $jamb = safe($_POST['jambNumber'] ?? '');
    if (!$jamb) throw new Exception('Missing jambNumber');

    $stmt = $pdo->prepare("SELECT id FROM students WHERE jamb_number = :j");
    $stmt->execute([':j'=>$jamb]);
    $student = $stmt->fetch();
    if (!$student) throw new Exception('Student not found.');

    $studentId = (int)$student['id'];
    $uploadDir = __DIR__ . '/uploads/passport_signature/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $updates = [];
    $params = [':id'=>$studentId];

    if (isset($_FILES['passport']) && $_FILES['passport']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['passport']['tmp_name']; $orig = $_FILES['passport']['name'];
        if (!allowed_file($tmp, $orig, $ALLOWED_EXT, $MAX_BYTES)) throw new Exception('Invalid passport file');
        $new = make_upload_name('passport', $orig);
        if (!move_uploaded_file($tmp, $uploadDir . $new)) throw new Exception('Failed to move passport');
        $rel = 'uploads/passport_signature/' . $new;
        $updates[] = "passport_path = :pp"; $params[':pp'] = $rel;
    }

    if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['signature']['tmp_name']; $orig = $_FILES['signature']['name'];
        if (!allowed_file($tmp, $orig, $ALLOWED_EXT, $MAX_BYTES)) throw new Exception('Invalid signature file');
        $new = make_upload_name('signature', $orig);
        if (!move_uploaded_file($tmp, $uploadDir . $new)) throw new Exception('Failed to move signature');
        $rel = 'uploads/passport_signature/' . $new;
        $updates[] = "signature_path = :sp"; $params[':sp'] = $rel;
    }

    if (count($updates) === 0) throw new Exception('No files uploaded');

    $sql = "UPDATE students SET " . implode(',', $updates) . " WHERE id = :id";
    $pdo->prepare($sql)->execute($params);

    // echo json_encode(['status'=>'success','student_id'=>$studentId]);
    header("Location: StudentAdmissionConfirmationPage5.php?student_id=" . $studentId);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
