<?php
require_once 'config.php';
require_once 'helpers.php';

header('Content-Type: application/json');

try {
    $studentId = (int)($_GET['id'] ?? 0);
    if (!$studentId) throw new Exception("Missing student ID");

    $stmt = $pdo->prepare("SELECT doc_type, file_path FROM student_documents WHERE student_id = :id");
    $stmt->execute([':id' => $studentId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$rows) throw new Exception("No documents found for this student");

    // Convert rows into key => path
    $docs = [];
    foreach ($rows as $row) {
        $docs[$row['doc_type']] = $row['file_path'];
    }

    echo json_encode(['status' => 'success', 'documents' => $docs]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
