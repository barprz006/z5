<?php declare(strict_types=1);
require_once 'db.php';
if (!isset($_SESSION['loggedin'])) { header('Location: logowanie.php'); exit(); }
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
        <h4>Usuń host z monitorowania (Pkt 13 i 14)</h4>
        <form method="post" action="kasuj2.php" class="card p-3 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Adres hosta do usunięcia:</label>
                <input type="text" name="host" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Numer portu:</label>
                <input type="number" name="port" class="form-control" value="80" required>
            </div>
            <button type="submit" class="btn btn-danger">Usuń usługę</button>
            <a href="index.php" class="btn btn-secondary mt-2">Powrót do tabeli</a>
        </form>
    </section>
</main>
<?php require_once 'footer.php'; ?>
</body>
</html>