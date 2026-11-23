<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}

$user_login = preg_replace('/[^a-zA-Z0-9_-]/', '', $_SESSION['username']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['folder_name'])) {
    $folder = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['folder_name']);
    if (!empty($folder)) {
        $path = $user_login . '/' . $folder;
        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }
    }
}
header('Location: index.php');
exit();
?>