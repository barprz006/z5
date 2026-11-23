<?php declare(strict_types=1);
require_once 'db.php';
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
<main class="w-100 m-auto" style="max-width: 420px; padding: 15px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h4 mb-3 fw-normal text-center">Rejestracja konta</h3>
            <?php if (isset($_GET['err'])): ?>
                <div class="alert alert-danger py-2"><?php echo htmlspecialchars($_GET['err']); ?></div>
            <?php endif; ?>
            <form method="post" action="add.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Login (tylko litery i cyfry):</label>
                    <input type="text" name="user" class="form-control" maxlength="20" pattern="[a-zA-Z0-9_-]+" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hasło:</label>
                    <input type="password" name="pass" class="form-control" maxlength="20" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Powtórz hasło:</label>
                    <input type="password" name="pass2" class="form-control" maxlength="20" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Avatar (opcjonalnie):</label>
                    <input type="file" name="avatar" class="form-control" accept="image/*">
                </div>
                <button class="w-100 btn btn-lg btn-success" type="submit">Zarejestruj</button>
            </form>
            <hr>
            <div class="text-center">
                <a href="logowanie.php" class="btn btn-outline-primary btn-sm w-100">Powrót do logowania</a>
            </div>
        </div>
    </div>
</main>
</body>
    </html><?php
