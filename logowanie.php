<?php declare(strict_types=1);
require_once 'db.php';
// logowanie usera
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit();
}
?>
    <!DOCTYPE html>
    <html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $tytul_strony; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="twoj_css.css">
</head>
<body class="d-flex align-items-center py-4">
<main class="w-100 m-auto" style="max-width: 400px; padding: 15px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h4 mb-3 fw-normal text-center">Formularz logowania</h3>
            <?php if (isset($_GET['err'])): ?>
                <div class="alert alert-danger py-2"><?php echo htmlspecialchars($_GET['err']); ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success py-2"><?php echo htmlspecialchars($_GET['msg']); ?></div>
            <?php endif; ?>
            <form method="post" action="weryfikuj.php" id="loginForm">
                <div class="mb-3">
                    <label class="form-label">Login:</label>
                    <input type="text" name="user" class="form-control" maxlength="20" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hasło:</label>
                    <input type="password" name="pass" class="form-control" maxlength="20" required>
                </div>
                <input type="hidden" name="ekran" id="ekran">
                <input type="hidden" name="okno" id="okno">
                <input type="hidden" name="kolory" id="kolory">
                <input type="hidden" name="ciasteczka" id="ciasteczka">
                <input type="hidden" name="java" id="java">
                <input type="hidden" name="jezyk" id="jezyk">

                <button class="w-100 btn btn-lg btn-primary" type="submit">Send (Zaloguj)</button>
            </form>
            <hr>
            <div class="text-center">
                <a href="rejestruj.php" class="btn btn-outline-secondary btn-sm w-100">Załóż nowe konto (Rejestracja)</a>
            </div>
        </div>
    </div>
</main>
<script>
    document.getElementById('ekran').value = screen.width + 'x' + screen.height;
    document.getElementById('okno').value = window.innerWidth + 'x' + window.innerHeight;
    document.getElementById('kolory').value = screen.colorDepth;
    document.getElementById('ciasteczka').value = navigator.cookieEnabled ? 'true' : 'false';
    document.getElementById('java').value = (typeof navigator.javaEnabled === 'function' && navigator.javaEnabled()) ? 'true' : 'false';
    document.getElementById('jezyk').value = navigator.language || navigator.userLanguage || '-';
</script>
</body>
    </html><?php
