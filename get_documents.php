<?php
require_once 'config.php';
require_once 'helpers.php';

header('Content-Type: application/json');

try {
    $studentId = (int)($_GET['id'] ?? 0);
    if (!$studentId) throw new Exception("Missing student ID");

    $stmt = $pdo->prepare("SELECT birth_cert, primary_cert, olevel_original, jamb_letter, jamb_result, indigene_cert 
                           FROM students_education 
                           WHERE student_id = :id");
    $stmt->execute([':id' => $studentId]);
    $docs = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$docs) throw new Exception("No documents found for this student");

    echo json_encode(['status' => 'success', 'documents' => $docs]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
