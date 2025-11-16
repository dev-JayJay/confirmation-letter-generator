<?php
// helpers.php

function safe($v) {
    return $v === null ? null : trim(htmlspecialchars((string)$v, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'));
}

function allowed_file($tmpPath, $filename, array $allowedExtensions, int $maxBytes) : bool {
    if (!is_uploaded_file($tmpPath)) return false;
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions, true)) return false;
    if (filesize($tmpPath) > $maxBytes) return false;
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmpPath);
    finfo_close($finfo);
    $allowedMimes = [
      'jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif','pdf'=>'application/pdf'
    ];
    return isset($allowedMimes[$ext]) && $mime === $allowedMimes[$ext];
}

function make_upload_name($prefix, $original) {
    $ext = pathinfo($original, PATHINFO_EXTENSION);
    return $prefix . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
}

function camel_to_snake($s) {
    return strtolower(preg_replace('/([A-Z])/', '_$1', $s));
}
