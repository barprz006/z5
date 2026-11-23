<?php declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_name('SESJA_BARTEK_' . substr(md5(__DIR__), 0, 8));
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Europe/Warsaw');

// dane bazy
$dbhost = "XXXXX";
$dbuser = "XXXXX";
$dbpassword = "XXXXX";
$dbname = "XXXXX";

$tytul_strony = "Bartek";

// połączenie z bazą
$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$link) {
    die("Błąd połączenia z MySQL: " . mysqli_connect_errno() . " " . mysqli_connect_error());
}
mysqli_query($link, "SET NAMES 'utf8'");
?>