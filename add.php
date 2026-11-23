<?php declare(strict_types=1);
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: rejestruj.php');
    exit();
}

$user = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['user'] ?? '');
$pass = htmlentities(is_string($_POST['pass'] ?? '') ? $_POST['pass'] : '', ENT_QUOTES, "UTF-8");
$pass2 = htmlentities(is_string($_POST['pass2'] ?? '') ? $_POST['pass2'] : '', ENT_QUOTES, "UTF-8");

if (empty($user) || empty($pass)) {
    header('Location: rejestruj.php?err=' . urlencode('Wypełnij poprawnie wszystkie pola!'));
    exit();
}

if ($pass !== $pass2) {
    header('Location: rejestruj.php?err=' . urlencode('Podane hasła nie są identyczne!'));
    exit();
}

$user_esc = mysqli_real_escape_string($link, $user);

$check = mysqli_query($link, "SELECT id FROM users WHERE username='$user_esc'");
if (!$check) {
    die("<div style='color:red; font-family:sans-serif; padding:20px; border:2px solid red;'>
        <h3>BŁĄD BAZY DANYCH PODCZAS REJESTRACJI (HTTP 500 UNIKNIĘTY)</h3>
        <p>Brak tabeli 'users' w bazie. Szczegóły z MySQL: <b>" . mysqli_error($link) . "</b></p>
        </div>");
}

if (mysqli_num_rows($check) > 0) {
    mysqli_close($link);
    header('Location: rejestruj.php?err=' . urlencode('Użytkownik o takim loginie już istnieje!'));
    exit();
}

$avatar_path = 'media/menu_icons/info.svg';
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    if (!is_dir('media/avatars')) {
        @mkdir('media/avatars', 0777, true);
    }
    $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
        $dest = 'media/avatars/' . $user . '.' . $ext;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)) {
            $avatar_path = $dest;
        }
    }
}

$pass_esc = mysqli_real_escape_string($link, $pass);
$av_esc = mysqli_real_escape_string($link, $avatar_path);

// dodanie do bazy
$insert = mysqli_query($link, "INSERT INTO users (username, password, avatar, worker) VALUES ('$user_esc', '$pass_esc', '$av_esc', 1)");

if (!$insert) {
    die("<div style='color:red; font-family:sans-serif; padding:20px; border:2px solid red;'>
        <h3>BŁĄD ZAPISU DO BAZY (HTTP 500 UNIKNIĘTY)</h3>
        <p>Błąd MySQL: <b>" . mysqli_error($link) . "</b></p>
        </div>");
}

if (!is_dir($user)) {
    @mkdir($user, 0777, true);
}

mysqli_close($link);
header('Location: logowanie.php?msg=' . urlencode('Konto utworzone! Możesz się zalogować.'));
exit();
?>