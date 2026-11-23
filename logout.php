<?php declare(strict_types=1);
require_once 'db.php';
session_unset();
session_destroy();
header('Location: logowanie.php');
exit();
?>