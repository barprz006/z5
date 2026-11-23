<?php
declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}

$user_login = preg_replace('/[^a-zA-Z0-9_-]/', '', $_SESSION['username']);
$subdir = $_SESSION['current_subdir'] ?? '';

$target_dir = $user_login;
if (!empty($subdir) && is_dir($user_login . '/' . $subdir)) {
    $target_dir = $user_login . '/' . $subdir;
}

if (!is_dir($target_dir)) {
    @mkdir($target_dir, 0777, true);
}

// upload pliku
if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . "/" . $filename;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        header('Location: index.php?subdir=' . urlencode($subdir));
        exit();
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Error uploading file.";
}
