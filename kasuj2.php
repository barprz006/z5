<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) { header('Location: logowanie.php'); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = mysqli_real_escape_string($link, trim($_POST['host'] ?? ''));
    $port = (int)($_POST['port'] ?? 80);
    $user_id = (int)$_SESSION['user_id'];
    $username = $_SESSION['username'];

    if ($username === 'admin') {
        mysqli_query($link, "DELETE FROM domeny WHERE host = '$host' AND port = $port");
    } else {
        mysqli_query($link, "DELETE FROM domeny WHERE host = '$host' AND port = $port AND user_id = $user_id");
    }
}
mysqli_close($link);
header('Location: index.php');
exit();
?>