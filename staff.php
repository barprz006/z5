<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = mysqli_real_escape_string($link, trim($_POST['host'] ?? ''));
    $port = (int)($_POST['port'] ?? 80);
    $worker_id = (int)($_POST['worker_id'] ?? 1);
    if (!empty($host) && $port > 0) {
        mysqli_query($link, "INSERT INTO domeny (host, port, user_id) VALUES ('$host', $port, $worker_id)");
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title><?php echo $tytul_strony; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="twoj_js.js"></script>
</head>
<body onload="myLoadHeader()">
<div id='myHeader'></div>
<main>
    <section class="sekcja1 container" style="max-width: 500px;">
        <h4>Przypisz host pracownikowi (Pkt 15.e - Staff)</h4>
        <form method="post" action="staff.php" class="card p-3 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Adres hosta:</label>
                <input type="text" name="host" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Numer portu:</label>
                <input type="number" name="port" class="form-control" value="80" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Wybierz pracownika (worker = true):</label>
                <select name="worker_id" class="form-select" required>
                    <?php
                    $res = mysqli_query($link, "SELECT id, username FROM users WHERE worker = 1");
                    while ($w = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$w['id']}'>" . htmlspecialchars($w['username']) . " (ID: {$w['id']})</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Przypisz zadanie</button>
        </form>
    </section>
</main>
<?php require_once 'footer.php'; ?>
</body>
</html>