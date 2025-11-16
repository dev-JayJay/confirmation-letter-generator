<?php
require_once 'config.php';
header('Content-Type: application/json');

$jamb = $_GET['jamb'] ?? '';
if (!$jamb) { http_response_code(400); echo json_encode(['status'=>'error','message'=>'Missing jamb']); exit; }

$stmt = $pdo->prepare("SELECT * FROM students WHERE jamb_number = :j");
$stmt->execute([':j'=>$jamb]);
$student = $stmt->fetch();
if (!$student) { http_response_code(404); echo json_encode(['status'=>'error','message'=>'Not found']); exit; }

$stmt = $pdo->prepare("SELECT * FROM students_education WHERE student_id = :sid");
$stmt->execute([':sid'=>$student['id']]); $education = $stmt->fetch();

$stmt = $pdo->prepare("SELECT subject_order, subject_name, grade FROM olevel_subjects WHERE student_id = :sid ORDER BY subject_order ASC");
$stmt->execute([':sid'=>$student['id']]); $subjects = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT doc_type, file_path FROM student_documents WHERE student_id = :sid");
$stmt->execute([':sid'=>$student['id']]); $docs = $stmt->fetchAll();

echo json_encode(['status'=>'success','student'=>$student,'education'=>$education,'subjects'=>$subjects,'documents'=>$docs]);
