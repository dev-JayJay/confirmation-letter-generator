<?php
require_once 'config.php';
header('Content-Type: application/json');

// Join students_education to get olevel_type
$stmt = $pdo->query("
    SELECT 
        s.id,
        s.jamb_number,
        CONCAT(s.surname,' ',s.firstname,' ',COALESCE(s.othername,'')) AS full_name,
        s.email,
        s.phone,
        s.course,
        s.admission_number,
        s.department,
        s.status,
        s.passport_path,
        s.signature_path,
        s.created_at,
        se.olevel_type 
    FROM students s
    LEFT JOIN students_education se ON s.id = se.student_id
    ORDER BY s.created_at DESC
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['status'=>'success','students'=>$rows]);
