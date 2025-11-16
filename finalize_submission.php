<?php
require_once 'config.php';
require_once 'helpers.php';
header('Content-Type: application/json');

try {
    $jamb = safe($_POST['jambNumber'] ?? '');
    if (!$jamb) throw new Exception('Missing jambNumber');
    $stmt = $pdo->prepare("SELECT id FROM students WHERE jamb_number = :j");
    $stmt->execute([':j'=>$jamb]);
    $student = $stmt->fetch();
    if (!$student) throw new Exception('Student not found');

    $pdo->prepare("UPDATE students SET status = 'submitted' WHERE jamb_number = :j")->execute([':j'=>$jamb]);
    echo json_encode(['status'=>'success']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
