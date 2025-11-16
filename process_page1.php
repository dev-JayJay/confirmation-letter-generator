<?php

require_once 'config.php';
require_once 'helpers.php';

header('Content-Type: application/json');

try {
    $jamb = safe($_POST['jambNumber'] ?? '');
    if (!$jamb) throw new Exception('Missing JAMB number');

    $fields = [
        'surname','firstname','othername','dob','gender','religion','email','maritalStatus',
        'phone','state','lga','nin','residentialAddress','homeAddress',
        'sponsorName','sponsorEmail','sponsorPhone','sponsorState','sponsorLga','sponsorAddress',
        'kinName','kinEmail','kinPhone','kinState','kinLga','kinAddress',
        'admission_number','course','department' 
    ];

    $data = [];
    foreach ($fields as $f) $data[$f] = safe($_POST[$f] ?? null);

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id FROM students WHERE jamb_number = :j");
    $stmt->execute([':j'=>$jamb]);
    $row = $stmt->fetch();

    if ($row) {
        $updateCols = [];
        $params = [':j'=>$jamb];
        foreach ($data as $k => $v) {
            $col = camel_to_snake($k);
            $updateCols[] = "$col = :$k";
            $params[":$k"] = $v;
        }
        $sql = "UPDATE students SET " . implode(",", $updateCols) . " WHERE jamb_number = :j";
        $pdo->prepare($sql)->execute($params);
        $studentId = $row['id'];
    } else {
        $cols = ['jamb_number'];
        $placeholders = [':jamb_number'];
        $params = [':jamb_number' => $jamb];
        foreach ($data as $k => $v) {
            $cols[] = camel_to_snake($k);
            $placeholders[] = ':' . $k;
            $params[':' . $k] = $v;
        }
        $sql = "INSERT INTO students (" . implode(',', $cols) . ") VALUES (" . implode(',', $placeholders) . ")";
        $pdo->prepare($sql)->execute($params);
        $studentId = (int)$pdo->lastInsertId();
    }

    $pdo->commit();

    header("Location: StudentAdmissionConfirmationPage3.php?student_id=" . $studentId);

} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
