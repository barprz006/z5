<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: logowanie.php');
    exit();
}

$user_login = preg_replace('/[^a-zA-Z0-9_-]/', '', $_SESSION['username']);
$subdir = !empty($_GET['subdir']) ? basename($_GET['subdir']) : '';
$item = !empty($_GET['item']) ? basename($_GET['item']) : '';

if (!empty($item) && $item !== '.' && $item !== '..') {
    $base_dir = $user_login;
    if (!empty($subdir) && is_dir($user_login . '/' . $subdir)) {
        $base_dir = $user_login . '/' . $subdir;
    }
    $target = $base_dir . '/' . $item;

    if (is_dir($target)) {
        $inner_files = scandir($target);
        foreach ($inner_files as $f) {
            if ($f !== '.' && $f !== '..') {
                $p = $target . '/' . $f;
                if (is_file($p)) {
                    @unlink($p);
                }
            }
        }
        @rmdir($target);
    } elseif (is_file($target)) {
        @unlink($target);
    }
}

header('Location: index.php?subdir=' . urlencode($subdir));
exit();
?>