<?php
require_once 'config.php';
require_once 'helpers.php';
header('Content-Type: application/json');

try {
    $id = (int)($_POST['id'] ?? 0);
    $status = safe($_POST['status'] ?? '');
    $admission_number = safe($_POST['admission_number'] ?? '');
    $department = safe($_POST['department'] ?? '');

    if (!$id || !$status) throw new Exception('Missing parameters');

    $params = [':id'=>$id, ':status'=>$status];
    $sql = "UPDATE students SET status = :status";

    if ($admission_number !== '') { $sql .= ", admission_number = :adm"; $params[':adm'] = $admission_number; }
    if ($department !== '') { $sql .= ", department = :dept"; $params[':dept'] = $department; }
    $sql .= " WHERE id = :id";

    $pdo->prepare($sql)->execute($params);
    echo json_encode(['status'=>'success']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
